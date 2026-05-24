<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController
{
    public function stats(Request $request)
    {
        $business = $request->user()->currentBusiness();

        if (!$business) {
            return response()->json(['error' => 'No business found for the user.'], 404);
        }

        $totalClients = $business->clients()->count();
        $totalInvoices = $business->invoices()->count();
        $totalRevenue = $business->invoices()->where('status', 'paid')->sum('total_amount') ?? 0;
        $outstanding = $business->invoices()->where('status', 'pending')->sum('total_amount') ?? 0;

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
