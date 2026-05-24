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

    public function createCheckoutSession(\App\Models\Invoice $invoice)
    {
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
            $invoiceId = $session->metadata->invoice_id;

            $invoice = \App\Models\Invoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'paid',
                    'amount_paid' => $invoice->grand_total,
                    'amount_due' => 0,
                ]);

                // Create a payment record if needed
                \App\Models\Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $invoice->grand_total,
                    'payment_date' => now(),
                    'payment_method' => 'stripe',
                    'notes' => 'Paid via Stripe. Reference: ' . $session->payment_intent,
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
