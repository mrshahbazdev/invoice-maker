<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController
{
    /**
     * Resolve the authenticated user's business.
     *
     * User has no current-business helper method: it has business() (belongsTo,
     * via business_id) and ownedBusiness() (hasOne). The web app uses
     * ->business everywhere, so it takes precedence and ownedBusiness is
     * the fallback for an owner whose business_id is not set.
     */
    private function resolveBusiness(Request $request)
    {
        $user = $request->user();

        return $user ? ($user->business ?? $user->ownedBusiness) : null;
    }

    public function stats(Request $request)
    {
        $business = $this->resolveBusiness($request);

        if (!$business) {
            return response()->json(['error' => 'No business found for the user.'], 404);
        }

        $totalClients = $business->clients()->count();
        $totalInvoices = $business->invoices()->count();
        // Invoices table has grand_total, not total_amount (see
        // 2024_01_01_000006_create_invoices_table). 'pending' is not in
        // the status enum (draft/sent/paid/overdue/cancelled), so
        // outstanding follows the web dashboard precedent: issued but
        // unpaid invoices, i.e. sent + overdue.
        $totalRevenue = $business->invoices()->where('status', Invoice::STATUS_PAID)->sum('grand_total') ?? 0;
        $outstanding = $business->invoices()->whereIn('status', [Invoice::STATUS_SENT, Invoice::STATUS_OVERDUE])->sum('grand_total') ?? 0;

        $recentInvoices = $business->invoices()
            ->with('client')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'stats' => [
                'total_clients' => $totalClients,
                'total_invoices' => $totalInvoices,
                'total_revenue' => $totalRevenue,
                'outstanding' => $outstanding,
            ],
            'recent_invoices' => $recentInvoices
        ]);
    }
}
