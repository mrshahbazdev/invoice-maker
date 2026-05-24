<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
 use WithPagination;

 public string $search = '';
 public string $sortBy = 'name';
 public string $sortDirection = 'asc';

 public function sortBy(string $field): void
 {
 if ($this->sortBy === $field) {
 $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
 } else {
 $this->sortBy = $field;
 $this->sortDirection = 'asc';
 }
 }

 public function delete(int $id): void
 {
 $client = Auth::user()->business->clients()->findOrFail($id);
 $client->delete();
 session()->flash('message', 'Client deleted successfully.');
 }

 public function render()
 {
 $clients = Auth::user()->business->clients()
 ->when($this->search, function ($query) {
 $query->where(function ($q) {
 $q->where('name', 'like', '%' . $this->search . '%')
 ->orWhere('email', 'like', '%' . $this->search . '%')
 ->orWhere('company_name', 'like', '%' . $this->search . '%');
 });
 })
 ->orderBy($this->sortBy, $this->sortDirection)
 ->paginate(10);

 return view('livewire.clients.index', compact('clients'));
 }
}
