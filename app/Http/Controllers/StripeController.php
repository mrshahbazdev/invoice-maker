<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;

class StripeController
{
    public function handleReturn()
    {
        $business = Auth::user()->business;

        if (!$business->stripe_account_id) {
            return redirect()->route('business.profile')->with('error', 'Stripe account not found.');
        }

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            $account = $stripe->accounts->retrieve($business->stripe_account_id);

            if ($account->details_submitted) {
                $business->update(['stripe_onboarding_complete' => true]);
                return redirect()->route('business.profile')->with('message', 'Stripe account connected successfully!');
            }

            return redirect()->route('business.profile')->with('error', 'Stripe onboarding was not completed.');
        } catch (\Exception $e) {
            return redirect()->route('business.profile')->with('error', 'Error connecting Stripe: ' . $e->getMessage());
        }
    }

    public function createCheckoutSession(Request $request, \App\Models\Invoice $invoice)
    {
        // GROUP C1 FIX 3: unauthenticated checkout creation requires a valid
        // signed URL, as PublicInvoiceController enforces in-controller for
        // show/download. Unsigned /v/{invoice}/pay links are rejected 403.
        if (!$request->hasValidSignature()) {
            return response('Invalid or expired invoice link.', 403);
        }

        // This will be called from the public invoice page
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $business = $invoice->business;

        if (!$business->stripe_onboarding_complete) {
            return back()->with('error', 'Payments are not enabled for this business.');
        }

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => strtolower($invoice->currency ?? $business->currency),
                        'product_data' => [
                            'name' => 'Invoice #' . $invoice->invoice_number,
                        ],
                        'unit_amount' => (int) ($invoice->amount_due * 100),
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('invoices.public.show', ['invoice' => $invoice->id]) . '?success=true',
            'cancel_url' => route('invoices.public.show', ['invoice' => $invoice->id]) . '?cancelled=true',
            'metadata' => [
                'invoice_id' => $invoice->id,
            ],
        ], [
            'stripe_account' => $business->stripe_account_id,
        ]);

        return redirect()->away($session->url);
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $invoiceId = $session->metadata->invoice_id ?? null;

            $invoice = \App\Models\Invoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'paid',
                    'amount_paid' => $invoice->grand_total,
                    'amount_due' => 0,
                ]);

                // GROUP C1 FIX 2: Payment::$fillable and the payments table
                // use method/date. payment_method/payment_date were silently
                // dropped by mass assignment, leaving NOT NULL date empty, so
                // the insert failed and the webhook 500ed AFTER the invoice
                // was already marked paid above.
                // Idempotency (existing columns only -- there is no dedicated
                // payment-intent column): reuse the notes text, which already
                // stores the intent and which PaymentController::success()
                // also searches, so a retried webhook does not double-log.
                $paymentIntentId = is_string($session->payment_intent)
                    ? $session->payment_intent
                    : ($session->payment_intent->id ?? null);
                $existingPayment = null;
                if (!empty($paymentIntentId)) {
                    $existingPayment = \App\Models\Payment::where('invoice_id', $invoice->id)
                        ->where('notes', 'LIKE', '%' . $paymentIntentId . '%')
                        ->first();
                }

                if (!$existingPayment) {
                    \App\Models\Payment::create([
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->grand_total,
                        'method' => 'stripe',
                        'date' => now(),
                        'notes' => 'Paid via Stripe. Reference: ' . $paymentIntentId,
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
