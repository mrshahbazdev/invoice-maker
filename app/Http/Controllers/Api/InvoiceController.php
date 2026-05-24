<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Services\InvoiceCalculationService;
use App\Services\InvoiceNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController
{
    public function index(Request $request)
    {
        $business = $request->user()->currentBusiness();
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }

        $invoices = Invoice::where('business_id', $business->id)
            ->with(['client', 'items'])
            ->orderBy('issue_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json($invoices);
    }

    public function store(Request $request)
    {
        $business = $request->user()->currentBusiness();

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.tax_percent' => 'nullable|numeric|min:0',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $invoiceNumberService = new InvoiceNumberService();
            $invoiceNumber = $invoiceNumberService->generate($business);

            // Calculate totals manually or via Service
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += $item['quantity'] * $item['price'];
            }

            $discount = $validated['discount_amount'] ?? 0;
            $taxPercent = $validated['tax_percent'] ?? 0;
            $taxAmount = ($subtotal - $discount) * ($taxPercent / 100);
            $totalAmount = ($subtotal - $discount) + $taxAmount;

            $invoice = Invoice::create([
                'business_id' => $business->id,
                'client_id' => $validated['client_id'],
                'invoice_number' => $invoiceNumber,
                'status' => 'draft',
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'],
                'subtotal' => $subtotal,
                'tax_percent' => $taxPercent,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discount,
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'currency' => $business->currency ?? 'USD',
                'template_id' => $business->template_id,
                'theme_id' => $business->theme_id,
            ]);

            foreach ($validated['items'] as $itemData) {
                $itemTotal = $itemData['quantity'] * $itemData['price'];
                $invoice->items()->create([
                    'name' => $itemData['name'],
                    'description' => $itemData['description'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['price'],
                    'tax_percent' => $itemData['tax_percent'] ?? 0,
                    'total' => $itemTotal,
                ]);
            }

            DB::commit();

            return response()->json($invoice->load(['client', 'items']), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create invoice', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, Invoice $invoice)
    {
        $business = $request->user()->currentBusiness();
        if ($invoice->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($invoice->load(['client', 'items']));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $business = $request->user()->currentBusiness();
        if ($invoice->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
        ]);

        $invoice->update(['status' => $validated['status']]);

        return response()->json($invoice);
    }
}
