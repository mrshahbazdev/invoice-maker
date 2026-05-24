<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceComment;
use App\Services\PdfGenerationService;
use Illuminate\Support\Facades\DB;

class PublicInvoiceController
{
    public function show(Request $request, Invoice $invoice)
    {
        $hasValidSignature = $request->hasValidSignature();

        \Log::info('PublicInvoiceController@show access', [
            'id' => $invoice->id,
            'url' => $request->fullUrl(),
            'hasValidSignature' => $hasValidSignature,
            'user' => auth()->id(),
            'app_url' => config('app.url'),
            'scheme' => $request->getScheme(),
            'host' => $request->getHost(),
        ]);

        if (!$hasValidSignature) {
            // Log exactly why it might be failing (optional, for very deep debug)
            return response()->view('errors.403', [
                'exception' => new \Exception('The link has an invalid or expired signature. Please ensure you are using the exact link provided.')
            ], 403);
        }

        $invoice->load(['client', 'business.user', 'items.product', 'payments']);

        // Set locale based on preference
        $locale = $invoice->client->language
            ?? $invoice->business->user->language
            ?? config('app.locale');
        \Illuminate\Support\Facades\App::setLocale($locale);

        // Throttle views to avoid spamming the database per IP per Invoice
        $cacheKey = 'invoice_viewed_' . $invoice->id . '_' . $request->ip();
        if (!cache()->has($cacheKey)) {
            $invoice->business->user->notify(new \App\Notifications\InvoiceViewedNotification($invoice));
            cache()->put($cacheKey, true, now()->addHours(1));
        }

        return view('invoices.public', compact('invoice'));
    }

    public function download(Request $request, Invoice $invoice, PdfGenerationService $pdfService)
    {
        if (!$request->hasValidSignature()) {
            return response('Invalid or expired invoice link.', 403);
        }

        // Set locale based on preference
        $locale = $invoice->client->language
            ?? $invoice->business->user->language
            ?? config('app.locale');
        \Illuminate\Support\Facades\App::setLocale($locale);

        return $pdfService->download($invoice);
    }

    public function approve(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            return response('Unauthorized signature.', 403);
        }

        if (!$invoice->isEstimate()) {
            abort(404);
        }

        if ($invoice->status === 'paid') {
            return redirect()->back()->with('success', 'Estimate is already approved.');
        }

        // Technically 'paid' means the estimate life cycle is closed/accepted
        $invoice->update(['status' => 'paid']);

        // Log the approval comment natively
        InvoiceComment::create([
            'invoice_id' => $invoice->id,
            'user_id' => $invoice->client->user_id ?? 1,
            'comment' => 'The client approved this Estimate. It has been automatically converted into a regular Draft Invoice.',
            'is_internal' => true,
        ]);

        // Auto-convert to Draft Invoice
        $business = $invoice->business;
        $defaultTerms = \App\Models\Setting::get('invoice.default_due_days', 14);

        // Use the InvoiceNumberService to get the next standard invoice number
        $numberService = app(\App\Services\InvoiceNumberService::class);

        $newInvoice = $invoice->replicate();
        $newInvoice->uuid = (string) \Illuminate\Support\Str::uuid();
        $newInvoice->invoice_number = $numberService->generate($business);
        $newInvoice->type = 'invoice';
        $newInvoice->status = 'draft';
        $newInvoice->invoice_date = now();
        $newInvoice->due_date = now()->addDays($defaultTerms);

        // Reset dynamic tracking fields
        $newInvoice->amount_paid = 0;
        $newInvoice->amount_due = $newInvoice->grand_total;
        $newInvoice->inventory_deducted = false;
        $newInvoice->save();

        // Replicate Items
        foreach ($invoice->items as $item) {
            $newItem = $item->replicate();
            $newItem->invoice_id = $newInvoice->id;
            $newItem->save();
        }

        // Notify Business Owner
        if ($invoice->business && $invoice->business->user) {
            $invoice->business->user->notify(new \App\Notifications\EstimateAcceptedNotification($invoice));
        }

        return redirect()->back()->with('success', 'Estimate has been approved and successfully converted into an Invoice. The business owner has been notified.');
    }

    public function requestRevision(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            return response('Unauthorized signature.', 403);
        }

        if (!$invoice->isEstimate()) {
            abort(404);
        }

        $invoice->update(['status' => 'draft']); // Back to draft for revision

        return redirect()->back()->with('success', 'Revision requested. The business owner will be notified.');
    }

    public function addComment(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature() && !auth()->check()) {
            return response('Unauthorized.', 403);
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        InvoiceComment::create([
            'invoice_id' => $invoice->id,
            'user_id' => auth()->id() ?? $invoice->client->user_id, // Fallback if guest but signed
            'comment' => $request->comment,
            'is_internal' => false,
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }
}
