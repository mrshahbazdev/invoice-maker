<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\AllocoreInvoiceService;
use App\Services\PdfGenerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AllocoreIntegrationController extends Controller
{
    protected AllocoreInvoiceService $service;

    public function __construct(AllocoreInvoiceService $service)
    {
        $this->service = $service;
    }

    /**
     * POST /api/allocore/clients/sync
     * Find or create a client from Allocore user data.
     */
    public function syncClient(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $client = $this->service->syncClient($validated);

        return response()->json([
            'client_id' => $client->id,
            'allocore_user_id' => $client->allocore_user_id,
            'name' => $client->name,
            'email' => $client->email,
        ], 200);
    }

    /**
     * POST /api/allocore/invoices
     * Create an invoice from an Allocore order.
     */
    public function createInvoice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|string',
            'bundle' => 'required|string|max:255',
            'tools' => 'nullable|array',
            'tools.*' => 'string',
            'amount' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'interval' => 'nullable|string|in:monthly,yearly',
            'status' => 'required|string|in:pending,paid,failed',
            'payment_method' => 'nullable|string',
            'subscription_id' => 'nullable|string',
            'notes' => 'nullable|string',
            'user' => 'required|array',
            'user.id' => 'required|string',
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|max:255',
            'user.company' => 'nullable|string|max:255',
            'user.phone' => 'nullable|string|max:50',
        ]);

        try {
            $invoice = $this->service->createInvoiceFromOrder($validated);

            $pdfUrl = route('invoices.public.download', $invoice->id);

            return response()->json([
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'status' => $invoice->status,
                'grand_total' => $invoice->grand_total,
                'amount_due' => $invoice->amount_due,
                'pdf_url' => $pdfUrl,
                'public_url' => route('invoices.public.show', $invoice->id),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Allocore invoice creation failed: ' . $e->getMessage(), [
                'order_id' => $validated['order_id'],
            ]);

            return response()->json([
                'error' => 'Failed to create invoice',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/allocore/invoices/{id}
     * Get invoice details including PDF URL.
     */
    public function showInvoice(Invoice $invoice): JsonResponse
    {
        if ($invoice->source !== 'allocore') {
            return response()->json(['error' => 'Not an Allocore invoice'], 403);
        }

        $invoice->load(['client', 'items', 'payments']);

        return response()->json([
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'allocore_order_id' => $invoice->allocore_order_id,
            'status' => $invoice->status,
            'invoice_date' => $invoice->invoice_date?->toDateString(),
            'due_date' => $invoice->due_date?->toDateString(),
            'subtotal' => $invoice->subtotal,
            'tax_total' => $invoice->tax_total,
            'grand_total' => $invoice->grand_total,
            'amount_paid' => $invoice->amount_paid,
            'amount_due' => $invoice->amount_due,
            'currency' => $invoice->currency,
            'is_recurring' => $invoice->is_recurring,
            'recurring_frequency' => $invoice->recurring_frequency,
            'pdf_url' => route('invoices.public.download', $invoice->id),
            'public_url' => route('invoices.public.show', $invoice->id),
            'client' => [
                'name' => $invoice->client->name,
                'email' => $invoice->client->email,
                'company' => $invoice->client->company_name,
            ],
            'items' => $invoice->items->map(fn ($item) => [
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'tax_rate' => $item->tax_rate,
                'total' => $item->total,
            ]),
            'payments' => $invoice->payments->map(fn ($p) => [
                'amount' => $p->amount,
                'method' => $p->method,
                'date' => $p->date?->toDateString(),
            ]),
        ]);
    }

    /**
     * POST /api/allocore/invoices/{id}/payment
     * Record a payment against an invoice.
     */
    public function recordPayment(Request $request, Invoice $invoice): JsonResponse
    {
        if ($invoice->source !== 'allocore') {
            return response()->json(['error' => 'Not an Allocore invoice'], 403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'nullable|string|in:bank_transfer,credit_card,paypal,stripe,cash',
            'date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $payment = $this->service->recordPayment($invoice, $validated);

        $invoice->refresh();

        return response()->json([
            'payment_id' => $payment->id,
            'invoice_status' => $invoice->status,
            'amount_paid' => $invoice->amount_paid,
            'amount_due' => $invoice->amount_due,
        ]);
    }

    /**
     * PUT /api/allocore/invoices/{id}/status
     * Update invoice status.
     */
    public function updateStatus(Request $request, Invoice $invoice): JsonResponse
    {
        if ($invoice->source !== 'allocore') {
            return response()->json(['error' => 'Not an Allocore invoice'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|string|in:draft,sent,paid,overdue,cancelled',
        ]);

        $invoice = $this->service->updateStatus($invoice, $validated['status']);

        return response()->json([
            'invoice_id' => $invoice->id,
            'status' => $invoice->status,
        ]);
    }

    /**
     * GET /api/allocore/invoices/by-order/{orderId}
     * Look up an invoice by Allocore order ID.
     */
    public function findByOrder(string $orderId): JsonResponse
    {
        $invoice = Invoice::where('allocore_order_id', $orderId)
            ->where('source', 'allocore')
            ->first();

        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found for this order'], 404);
        }

        return $this->showInvoice($invoice);
    }
}
