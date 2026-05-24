<?php

namespace App\Livewire\Client\Tickets;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
 use WithPagination;

 #[\Livewire\Attributes\Layout('layouts.app')]
 public function render()
 {
 $tickets = Ticket::where('user_id', Auth::id())
 ->orderBy('created_at', 'desc')
 ->paginate(10);

 return view('livewire.client.tickets.index', [
 'tickets' => $tickets
 ]);
 }
}
