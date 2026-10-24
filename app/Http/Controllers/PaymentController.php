<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout(Invoice $invoice)
    {
        // 1. Validate invoice is payable
        if ($invoice->status === Invoice::STATUS_PAID || $invoice->status === Invoice::STATUS_CANCELLED) {
            return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('This invoice cannot be paid right now.'));
        }

        $business = $invoice->business;

        // 2. Validate Stripe keys
        if (empty($business->stripe_public_key) || empty($business->stripe_secret_key)) {
            return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('Online payments are not configured by the business.'));
        }

        // 3. Init Stripe
        Stripe::setApiKey($business->stripe_secret_key);

        try {
            // 4. Create Line Items
            $lineItems = [];
            foreach ($invoice->items as $item) {
                // Stripe wants amounts in cents
                $lineItems[] = [
                    'price_data' => [
                        'currency' => strtolower($business->currency ?? 'usd'),
                        'unit_amount' => round($item->unit_price * 100),
                        'product_data' => [
                            'name' => $item->description,
                        ],
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            // If there's tax, we could add a separate line item or use Stripe's tax rates.
            // For MVP simplicity, let's just make the entire invoice total a single line item
            // to perfectly match the final calculated amount (including all discounts/taxes).

            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => strtolower($business->currency ?? 'usd'),
                            'unit_amount' => round($invoice->amount_due * 100),
                            'product_data' => [
                                'name' => 'Invoice ' . $invoice->invoice_number,
                                'description' => 'Payment for ' . ($invoice->client->name ?? 'Client'),
                            ],
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['invoice' => $invoice->uuid]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('invoices.public.show', $invoice->uuid),
                'client_reference_id' => $invoice->id,
            ]);

            return redirect()->away($checkoutSession->url);

        } catch (\Exception $e) {
            \Log::error('Stripe Checkout Error: ' . $e->getMessage());
            return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('There was an error connecting to the payment gateway.'));
        }
    }

    public function success(Request $request, Invoice $invoice)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('Invalid payment session.'));
        }

        $business = $invoice->business;
        Stripe::setApiKey($business->stripe_secret_key);

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // GROUP C1 FIX 1(a): the Stripe session must belong to THIS invoice.
                // PaymentController::checkout() sets client_reference_id to the
                // invoice id; StripeController::createCheckoutSession() sets
                // metadata.invoice_id. A session carrying neither reference, or
                // either reference pointing at a different invoice, cannot be
                // used to mark this invoice paid (previously any paid session
                // id supplied in the URL marked the URL invoice paid).
                $clientReferenceId = !empty($session->client_reference_id)
                    ? (string) $session->client_reference_id
                    : null;
                $metadataInvoiceId = !empty($session->metadata) && !empty($session->metadata->invoice_id)
                    ? (string) $session->metadata->invoice_id
                    : null;

                if ($clientReferenceId === null && $metadataInvoiceId === null) {
                    \Log::warning('Stripe Success: session has no invoice reference.', ['invoice_id' => $invoice->id]);
                    return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('Could not verify payment status.'));
                }

                if (($clientReferenceId !== null && $clientReferenceId !== (string) $invoice->id)
                    || ($metadataInvoiceId !== null && $metadataInvoiceId !== (string) $invoice->id)) {
                    \Log::warning('Stripe Success: session invoice reference does not match URL invoice.', ['invoice_id' => $invoice->id]);
                    return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('Could not verify payment status.'));
                }

                // Normalize the payment intent id: stripe-php v19 returns it as
                // a string, or as an expanded PaymentIntent object.
                $paymentIntentId = is_string($session->payment_intent)
                    ? $session->payment_intent
                    : ($session->payment_intent->id ?? null);

                // Strengthened deduplication (existing columns only): a payment
                // whose notes already contain this payment intent -- including
                // one created by the Stripe webhook -- is never created twice,
                // so refreshing the success page (or a webhook arriving first)
                // does not double-log the payment. Checked BEFORE the amount
                // check so a success-page refresh after the webhook already
                // settled the invoice (amount_due now 0) still lands on the
                // success message instead of an amount-mismatch error.
                $existingPayment = null;
                if (!empty($paymentIntentId)) {
                    $existingPayment = Payment::where('notes', 'LIKE', '%' . $paymentIntentId . '%')->first();
                }

                if (!$existingPayment) {
                    // GROUP C1 FIX 1(b): session amount AND currency must equal
                    // the amount due. Stripe amounts are integer minor units;
                    // the invoice stores major units.
                    $expectedCents = (int) round((float) $invoice->amount_due * 100);
                    $sessionCurrency = !empty($session->currency) ? strtolower((string) $session->currency) : null;
                    $invoiceCurrency = strtolower((string) ($invoice->currency ?? $business->currency ?? 'usd'));

                    if ($session->amount_total === null || (int) $session->amount_total !== $expectedCents || $sessionCurrency !== $invoiceCurrency) {
                        \Log::warning('Stripe Success: session amount or currency does not match amount due.', ['invoice_id' => $invoice->id]);
                        return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('Could not verify payment status.'));
                    }

                    // GROUP C1 FIX 1(c): amount_due is the real amount field.
                    // total_amount does not exist on the Invoice model, so the
                    // old code stored NULL amounts here.
                    Payment::create([
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->amount_due,
                        'method' => Payment::METHOD_STRIPE,
                        'date' => now(),
                        'notes' => 'Stripe Payment Intent: ' . $paymentIntentId,
                    ]);

                    // Update invoice status
                    $invoice->update(['status' => Invoice::STATUS_PAID]);

                    if ($business->user) {
                        $business->user->notify(new \App\Notifications\InvoicePaidNotification($invoice));
                    }

                    // Create Cashbook entry automatically
                    \App\Models\CashBookEntry::create([
                        'business_id' => $business->id,
                        'type' => 'income',
                        'amount' => $invoice->amount_due,
                        'description' => 'Online Payment for Invoice ' . $invoice->invoice_number,
                        'date' => now()->format('Y-m-d'),
                        'is_recurring' => false,
                        'invoice_id' => $invoice->id,
                    ]);
                }

                return redirect()->route('invoices.public.show', $invoice->uuid)->with('message', __('Payment successful! Thank you for your business.'));
            }

        } catch (\Exception $e) {
            \Log::error('Stripe Success Error: ' . $e->getMessage());
            return redirect()->route('invoices.public.show', $invoice->uuid)->with('error', __('Could not verify payment status.'));
        }

        return redirect()->route('invoices.public.show', $invoice->uuid);
    }
}
