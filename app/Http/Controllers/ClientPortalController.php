<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Show the registration form for a client to create an account.
     */
    public function showRegistrationForm(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired magic link. Please request a new one from the business.');
        }

        if ($invoice->client->user_id) {
            return redirect()->route('login')->with('info', 'You already have an account. Please sign in.');
        }

        return view('client-portal.register', compact('invoice'));
    }

    /**
     * Register a new client user account.
     */
    public function register(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired magic link. Please request a new one from the business.');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $client = $invoice->client;

        if ($client->user_id) {
            return redirect()->route('login')->with('info', 'You already have an account. Please sign in.');
        }

        // Create the user
        $user = User::create([
            'name' => $client->name,
            'email' => $client->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_VIEWER,
            'is_active' => true,
        ]);

        // Link the user to the client
        $client->update(['user_id' => $user->id]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Account created successfully!');
    }

    /**
     * Display the authenticated client's dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $clients = $user->clients;
        $clientIds = $clients->pluck('id');

        $invoices = Invoice::whereIn('client_id', $clientIds)
            ->where('type', 'invoice')
            ->with(['business'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $allInvoices = Invoice::whereIn('client_id', $clientIds)->where('type', 'invoice')->get();
        $totalPaid = $allInvoices->sum('amount_paid');
        $totalPending = $allInvoices->where('status', '!=', 'paid')->where('status', '!=', 'overdue')->sum('amount_due');
        $totalOverdue = $allInvoices->where('status', 'overdue')->sum('amount_due');

        return view('client-portal.dashboard', compact('invoices', 'totalPaid', 'totalPending', 'totalOverdue'));
    }

    /**
     * Download all invoices.
     */
    public function downloadAllInvoices(Request $request)
    {
        abort(501, 'Downloading all invoices as a ZIP is not yet implemented.');
    }

    /**
     * Download statement of account.
     */
    public function downloadStatement(Request $request)
    {
        abort(501, 'Downloading statement of account is not yet implemented.');
    }
}
