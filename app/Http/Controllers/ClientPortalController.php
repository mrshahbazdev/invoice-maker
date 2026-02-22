<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Services\PdfGenerationService;
use PhpZip\ZipFile;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientPortalController
{
    public function showRegistrationForm(Request $request, Invoice $invoice)
    {
        // Ensure the invoice belongs to a client
        if (!$invoice->client) {
            abort(404);
        }

        // If client already has a user account, redirect to login
        if ($invoice->client->user_id) {
            return redirect()->route('login')->with('status', 'Please login to view your invoices.');
        }

        return view('client-portal.register', compact('invoice'));
    }

    public function register(Request $request, Invoice $invoice)
    {
        // Ensure the invoice belongs to a client without an account
        if (!$invoice->client || $invoice->client->user_id) {
            abort(403, 'Invalid registration link.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'name' => $invoice->client->name,
            'email' => $invoice->client->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'client',
        ]);

        // Link the user to the client record
        $invoice->client->update(['user_id' => $user->id]);

        // Log the user in
        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Account created successfully! Welcome to your dashboard.');
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Ensure only clients access this
        if ($user->role !== 'client') {
            return redirect()->route('dashboard'); // Redirect business owners to their app dashboard
        }

        // Fetch all invoices associated with this client's user_id
        // A user might be associated with multiple client records across different businesses if they use the same email,
        // but for this MVP, we assume a simple relationship or fetch all client profiles linked to this user.
        $clientIds = $user->clients()->pluck('id');

        $query = \App\Models\Invoice::whereIn('client_id', $clientIds)
            ->with(['business', 'items']);

        // Calculate stats using the query builder before paginating
        $totalPaid = (clone $query)->sum('amount_paid');
        $totalPending = (clone $query)->whereIn('status', ['draft', 'sent', 'viewed', 'partial'])->sum('amount_due');
        $totalOverdue = (clone $query)->where('status', 'overdue')->sum('amount_due');

        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('client-portal.dashboard', compact('invoices', 'totalPaid', 'totalPending', 'totalOverdue'));
    }

    public function downloadAllInvoices(PdfGenerationService $pdfService)
    {
        $user = auth()->user();
        $clientIds = $user->clients()->pluck('id');
        $invoices = Invoice::whereIn('client_id', $clientIds)->get();

        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'No invoices found to download.');
        }

        $zipFile = new ZipFile();

        foreach ($invoices as $invoice) {
            /** @var \App\Models\Invoice $invoice */
            $pdfContent = $pdfService->generate($invoice);
            $filename = "Invoice_{$invoice->invoice_number}.pdf";
            $zipFile->addFromString($filename, $pdfContent);
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'invoices_zip');
        $zipFile->saveAsFile($tempFile);
        $zipFile->close();

        return response()->download($tempFile, 'all_invoices.zip')->deleteFileAfterSend(true);
    }

    public function downloadStatement()
    {
        $user = auth()->user();
        $client = $user->clients()->first();
        $business = $client->business;

        $invoices = Invoice::where('client_id', $client->id)->get();
        $totalInvoiced = $invoices->sum('grand_total');
        $totalPaid = $invoices->sum('amount_paid');
        $totalOutstanding = $totalInvoiced - $totalPaid;

        $pdf = Pdf::loadView('client-portal.statement-pdf', compact(
            'client',
            'business',
            'invoices',
            'totalInvoiced',
            'totalPaid',
            'totalOutstanding'
        ));

        return $pdf->download('Statement_of_Account.pdf');
    }
}
