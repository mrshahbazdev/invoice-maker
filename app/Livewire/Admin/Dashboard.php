<?php namespace App\Livewire\Admin; use Livewire\Component;
use App\Models\User;
use App\Models\Business;
use App\Models\Invoice; class Dashboard extends Component
{ public function render() { $totalUsers = User::count(); $totalBusinesses = Business::count(); $invoicesGenerated = Invoice::count(); // MVP Revenue Calculation: Sum of all paid invoices $totalRevenue = Invoice::where('status', Invoice::STATUS_PAID)->sum('grand_total'); $recentUsers = User::latest()->take(5)->get(); return view('livewire.admin.dashboard', compact( 'totalUsers', 'totalBusinesses', 'invoicesGenerated', 'totalRevenue', 'recentUsers' ))->layout('layouts.admin', ['title' => 'Super Admin']); }
}
