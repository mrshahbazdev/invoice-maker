<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
 use WithPagination;

 public $search = '';

 public function updatingSearch()
 {
 $this->resetPage();
 }

 public function toggleActive($userId)
 {
 $user = User::findOrFail($userId);

 // Prevent super admin from suspending themselves
 if ($user->id === auth()->id()) {
 return;
 }

 $user->is_active = !$user->is_active;
 $user->save();
 }

 public function impersonate($userId)
 {
 $user = User::findOrFail($userId);

 // Prevent impersonating another super admin (including self)
 if ($user->is_super_admin) {
 return;
 }

 // Store original admin ID in session
 session()->put('impersonated_by', auth()->id());

 // Login as the target user
 auth()->loginUsingId($user->id);

 return redirect()->route('dashboard');
 }

 public function render()
 {
 $users = User::with('business')
 ->where(function ($query) {
 $query->where('name', 'like', "%{$this->search}%")
 ->orWhere('email', 'like', "%{$this->search}%");
 })
 ->latest()
 ->paginate(15);

 return view('livewire.admin.users.index', compact('users'))
 ->layout('layouts.admin', ['title' => 'User Management']);
 }
}
