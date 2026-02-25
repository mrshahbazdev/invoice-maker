<?php

namespace App\Livewire\Client\Tickets;

use App\Models\Ticket;
use App\Models\TicketReply;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
 use WithFileUploads;

 public $subject;
 public $category = 'general';
 public $priority = 'medium';
 public $message;
 public $attachment;

 protected $rules = [
 'subject' => 'required|string|max:255',
 'category' => 'required|string|in:general,technical,billing',
 'priority' => 'required|string|in:low,medium,high,urgent',
 'message' => 'required|string',
 'attachment' => 'nullable|file|max:5120', // 5MB Max
 ];

 public function createTicket()
 {
 $this->validate();

 $ticket = Ticket::create([
 'user_id' => Auth::id(),
 'subject' => $this->subject,
 'category' => $this->category,
 'priority' => $this->priority,
 'status' => 'open',
 ]);

 $attachmentPath = null;
 if ($this->attachment) {
 $attachmentPath = $this->attachment->store('tickets/attachments', 'public');
 }

 TicketReply::create([
 'ticket_id' => $ticket->id,
 'user_id' => Auth::id(),
 'message' => $this->message,
 'attachment_path' => $attachmentPath,
 ]);

 session()->flash('message', 'Support ticket created successfully. Our team will review it shortly.');
 return $this->redirect(route('client.tickets.show', $ticket), navigate: true);
 }

 #[\Livewire\Attributes\Layout('layouts.app')]
 public function render()
 {
 return view('livewire.client.tickets.create');
 }
}
