<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use App\Services\InvoiceCalculationService;
use App\Services\InvoiceNumberService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Resolve the authenticated user's business.
     *
     * User has no current-business helper method: it has business() (belongsTo,
     * via business_id) and ownedBusiness() (hasOne). The web app uses
     * ->business everywhere (e.g. Livewire/Invoices/Create), so it takes
     * precedence and ownedBusiness is the fallback for an owner whose
     * business_id is not set.
     */
    private function resolveBusiness(Request $request)
    {
        $user = $request->user();

        return $user ? ($user->business ?? $user->ownedBusiness) : null;
    }

    /**
     * Validation rules shared by store() and update().
     *
     * Column names follow the real schema, not the old API payload names:
     * invoices has invoice_date (not issue_date), tax_total (not
     * tax_percent/tax_amount), discount (not discount_amount), grand_total
     * (not total_amount) and payment_terms (not terms); invoice_items has
     * description (not name), unit_price (not price) and tax_rate (not
     * tax_percent). The legacy names are still accepted as input aliases
     * and mapped below, so existing API clients keep working.
     */
    private function validationRules($business, bool $allowStatus = false): array
    {
        $rules = [
            'client_id' => 'required|exists:clients,id,business_id,'.$business->id,
            'invoice_date' => 'nullable|date|required_without:issue_date',
            'issue_date' => 'nullable|date',
            'due_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id,business_id,'.$business->id,
            'items.*.description' => 'nullable|string',
            'items.*.name' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'items.*.price' => 'nullable|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0',
            'items.*.tax_percent' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'terms' => 'nullable|string',
            'currency' => 'nullable|string|max:3',
            'template_id' => 'nullable|exists:templates,id,business_id,'.$business->id,
        ];

        if ($allowStatus) {
            $rules['status'] = 'sometimes|in:draft,sent,paid,overdue,cancelled';
        }

        return $rules;
    }

    /**
     * Resolve invoice_date (validated input, legacy issue_date alias, or
     * today as in the web create flow) and check due_date against it.
     * Returns [invoiceDate, dueDate] or a 422 response array on failure.
     */
    private function resolveDates(array $validated)
    {
        $invoiceDate = $validated['invoice_date'] ?? $validated['issue_date'] ?? now()->toDateString();
        $invoiceDate = \Carbon\Carbon::parse($invoiceDate)->toDateString();
        $dueDate = \Carbon\Carbon::parse($validated['due_date'])->toDateString();

        if ($dueDate < $invoiceDate) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => ['due_date' => ['The due date must be a date after or equal to the invoice date.']],
            ], 422);
        }

        return [$invoiceDate, $dueDate];
    }

    /**
     * Normalise items to the InvoiceCalculationService shape. Returns the
     * items array, or a 422 response if an item lacks a description
     * (description/name alias) or a price (unit_price/price alias).
     * A per-item tax_rate/tax_percent wins; otherwise the invoice-level
     * tax_percent applies to every item, so invoice tax_total stays
     * consistent with the sum of item tax_amounts.
     */
    private function normalizeItems(array $validated)
    {
        $invoiceTaxPercent = $validated['tax_percent'] ?? null;
        $items = [];

        foreach ($validated['items'] as $itemData) {
            $description = $itemData['description'] ?? $itemData['name'] ?? null;
            $unitPrice = $itemData['unit_price'] ?? $itemData['price'] ?? null;

            if ($description === null || trim((string) $description) === '' || $unitPrice === null) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => ['items' => ['Each item requires a description (or name) and a unit price (or price).']],
                ], 422);
            }

            $items[] = [
                'product_id' => $itemData['product_id'] ?? null,
                'description' => $description,
                'quantity' => $itemData['quantity'],
                'unit_price' => $unitPrice,
                'tax_rate' => $itemData['tax_rate'] ?? $itemData['tax_percent'] ?? $invoiceTaxPercent ?? 0,
                'discount' => $itemData['discount'] ?? 0,
            ];
        }

        return $items;
    }

    /**
     * Attach tax_amount/total to normalised items. InvoiceCalculationService
     * returns invoice totals but its returned 'items' carry no tax_amount /
     * total (it mutates a loop copy), so item amounts are computed here
     * with the same formula the web flow uses in updateItemTotal().
     */
    private function calculatedItems(array $items): array
    {
        foreach ($items as &$item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $item['tax_amount'] = $lineTotal * ($item['tax_rate'] / 100);
            $item['total'] = $lineTotal + $item['tax_amount'] - $item['discount'];
        }
        unset($item);

        return $items;
    }

    public function index(Request $request)
    {
        $business = $this->resolveBusiness($request);
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }

        $invoices = Invoice::where('business_id', $business->id)
            ->with(['client', 'items'])
            ->orderBy('invoice_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json($invoices);
    }

    public function store(Request $request)
    {
        $business = $this->resolveBusiness($request);
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }

        $validated = $request->validate($this->validationRules($business));

        $dates = $this->resolveDates($validated);
        if ($dates instanceof \Illuminate\Http\JsonResponse) {
            return $dates;
        }
        [$invoiceDate, $dueDate] = $dates;

        $items = $this->normalizeItems($validated);
        if ($items instanceof \Illuminate\Http\JsonResponse) {
            return $items;
        }

        $discount = $validated['discount'] ?? $validated['discount_amount'] ?? 0;
        $totals = (new InvoiceCalculationService())->calculate($items, (float) $discount);

        try {
            DB::beginTransaction();

            $invoiceNumberService = new InvoiceNumberService();
            $invoiceNumber = $invoiceNumberService->generate($business);

            // invoices has no theme_id column and no 'terms' column;
            // payment_terms is the real column (web create flow sets it
            // from the business default). template_id defaults to the
            // business default template, as in the web create flow.
            $invoice = Invoice::create([
                'business_id' => $business->id,
                'client_id' => $validated['client_id'],
                'invoice_number' => $invoiceNumber,
                'status' => 'draft',
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'subtotal' => $totals['subtotal'],
                'tax_total' => $totals['tax_total'],
                'discount' => $totals['discount'],
                'grand_total' => $totals['grand_total'],
                'amount_paid' => 0,
                'amount_due' => $totals['grand_total'],
                'notes' => $validated['notes'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? $validated['terms'] ?? $business->payment_terms,
                'currency' => $validated['currency'] ?? $business->currency ?? 'USD',
                'template_id' => $validated['template_id'] ?? $business->templates()->where('is_default', true)->first()?->id,
            ]);

            foreach ($this->calculatedItems($items) as $itemData) {
                $invoice->items()->create([
                    'product_id' => $itemData['product_id'],
                    'description' => $itemData['description'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'tax_rate' => $itemData['tax_rate'],
                    'tax_amount' => $itemData['tax_amount'],
                    'discount' => $itemData['discount'],
                    'total' => $itemData['total'],
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
        $business = $this->resolveBusiness($request);
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }
        if ($invoice->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($invoice->load(['client', 'items']));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $business = $this->resolveBusiness($request);
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }
        if ($invoice->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate($this->validationRules($business, true));

        $dates = $this->resolveDates($validated);
        if ($dates instanceof \Illuminate\Http\JsonResponse) {
            return $dates;
        }
        [$invoiceDate, $dueDate] = $dates;

        $items = $this->normalizeItems($validated);
        if ($items instanceof \Illuminate\Http\JsonResponse) {
            return $items;
        }

        $discount = $validated['discount'] ?? $validated['discount_amount'] ?? $invoice->discount ?? 0;
        $totals = (new InvoiceCalculationService())->calculate($items, (float) $discount);

        try {
            DB::beginTransaction();

            // Invoice number and business are never changed by an update.
            // amount_due preserves what is already paid instead of
            // resetting to the grand total.
            $invoice->update([
                'client_id' => $validated['client_id'],
                'status' => $validated['status'] ?? $invoice->status,
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'subtotal' => $totals['subtotal'],
                'tax_total' => $totals['tax_total'],
                'discount' => $totals['discount'],
                'grand_total' => $totals['grand_total'],
                'amount_due' => max($totals['grand_total'] - (float) $invoice->amount_paid, 0),
                'notes' => $validated['notes'] ?? $invoice->notes,
                'payment_terms' => $validated['payment_terms'] ?? $validated['terms'] ?? $invoice->payment_terms,
                'currency' => $validated['currency'] ?? $invoice->currency,
                'template_id' => $validated['template_id'] ?? $invoice->template_id,
            ]);

            // Same item-replacement pattern as Livewire/Invoices/Edit.
            $invoice->items()->delete();

            foreach ($this->calculatedItems($items) as $itemData) {
                $invoice->items()->create([
                    'product_id' => $itemData['product_id'],
                    'description' => $itemData['description'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'tax_rate' => $itemData['tax_rate'],
                    'tax_amount' => $itemData['tax_amount'],
                    'discount' => $itemData['discount'],
                    'total' => $itemData['total'],
                ]);
            }

            DB::commit();

            return response()->json($invoice->fresh()->load(['client', 'items']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update invoice', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, Invoice $invoice)
    {
        $business = $this->resolveBusiness($request);
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }
        if ($invoice->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Items, payments, comments and email logs cascade at the FK
        // level (onDelete cascade); cash-book entries / expenses are
        // set null, so deleting this one scoped invoice is self-contained.
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted']);
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $business = $this->resolveBusiness($request);
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }
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
