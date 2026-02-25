<?php namespace App\Livewire\Client\Tickets; use App\Models\Ticket;
use App\Models\TicketReply;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth; class Show extends Component
{ use WithFileUploads; public Ticket $ticket; public $message; public $attachment; protected $rules = [ 'message' => 'required|string', 'attachment' => 'nullable|file|max:5120', // 5MB Max ]; public function mount(Ticket $ticket) { // Ensure user owns this ticket if ($ticket->user_id !== Auth::id()) { abort(403); } $this->ticket = $ticket; } public function reply() { $this->validate(); $attachmentPath = null; if ($this->attachment) { $attachmentPath = $this->attachment->store('tickets/attachments', 'public'); } TicketReply::create([ 'ticket_id' => $this->ticket->id, 'user_id' => Auth::id(), 'message' => $this->message, 'attachment_path' => $attachmentPath, ]); // Re-open if closed if ($this->ticket->status === 'closed' || $this->ticket->status === 'resolved') { $this->ticket->update(['status' => 'open']); } $this->reset('message', 'attachment'); $this->js('$dispatch("reply-added")'); } #[\Livewire\Attributes\Layout('layouts.app')] public function render() { return view('livewire.client.tickets.show', [ 'replies' => $this->ticket->replies()->with('user')->orderBy('created_at', 'asc')->get() ]); }
}
