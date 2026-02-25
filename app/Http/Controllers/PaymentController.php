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
                            'unit_amount' => round($invoice->total_amount * 100),
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
                // Ensure we don't double-log the payment if the user refreshes the success page
                $existingPayment = Payment::where('notes', 'LIKE', '%' . $session->payment_intent . '%')->first();

                if (!$existingPayment) {
                    // Create the payment record
                    Payment::create([
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total_amount,
                        'method' => Payment::METHOD_STRIPE,
                        'date' => now(),
                        'notes' => 'Stripe Payment Intent: ' . $session->payment_intent,
                    ]);

                    // Update invoice status
                    $invoice->update(['status' => Invoice::STATUS_PAID]);

                    // Create Cashbook entry automatically
                    \App\Models\CashBookEntry::create([
                        'business_id' => $business->id,
                        'type' => 'income',
                        'amount' => $invoice->total_amount,
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
