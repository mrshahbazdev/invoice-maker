<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ClientPortalController
{
    /**
     * Display the client portal dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function index(Request $request, Client $client)
    {
        // Require a valid signature on the URL to ensure security
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired magic link. Please request a new one from the business.');
        }

        $business = $client->business;

        // Eager load invoices with items for accurate totals
        $client->load([
            'invoices' => function ($query) {
                $query->orderBy('invoice_date', 'desc');
            }
        ]);

        // Calculate totals
        $totalPaid = $client->invoices->where('type', 'invoice')->sum('amount_paid');
        $totalDue = $client->invoices->where('type', 'invoice')->sum('amount_due');
        $totalBilled = $client->invoices->where('type', 'invoice')->sum('grand_total');

        $invoices = $client->invoices->where('type', 'invoice');
        $estimates = $client->invoices->where('type', 'estimate');

        return view('client-portal.index', compact('client', 'business', 'totalPaid', 'totalDue', 'totalBilled', 'invoices', 'estimates'));
    }
}
