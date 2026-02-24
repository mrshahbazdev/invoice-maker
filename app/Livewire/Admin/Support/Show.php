<?php

namespace App\Livewire\Admin\Support;

use App\Models\Ticket;
use App\Models\TicketReply;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    use WithFileUploads;

    public Ticket $ticket;
    public $message;
    public $attachment;

    public $status;
    public $priority;
    public $category;

    protected $rules = [
        'message' => 'required|string',
        'attachment' => 'nullable|file|max:5120', // 5MB Max
        'status' => 'required|string|in:open,in_progress,resolved,closed',
        'priority' => 'required|string|in:low,medium,high,urgent',
        'category' => 'required|string|in:general,technical,billing',
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->status = $ticket->status;
        $this->priority = $ticket->priority;
        $this->category = $ticket->category;
    }

    public function reply()
    {
        $this->validateOnly('message');
        $this->validateOnly('attachment');

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('tickets/attachments', 'public');
        }

        TicketReply::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => Auth::id(),
            'message' => $this->message,
            'attachment_path' => $attachmentPath,
        ]);

        if ($this->ticket->status === 'closed') {
            $this->ticket->update(['status' => 'in_progress']);
            $this->status = 'in_progress';
        }

        $this->ticket->touch(); // Update the updated_at timestamp

        $this->reset('message', 'attachment');
        $this->js('$dispatch("reply-added")');
    }

    public function updateTicketDetails()
    {
        $this->validateOnly('status');
        $this->validateOnly('priority');
        $this->validateOnly('category');

        $this->ticket->update([
            'status' => $this->status,
            'priority' => $this->priority,
            'category' => $this->category,
        ]);

        session()->flash('message', 'Ticket details updated successfully.');
    }

    #[\Livewire\Attributes\Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.support.show', [
            'replies' => $this->ticket->replies()->with('user')->orderBy('created_at', 'asc')->get()
        ]);
    }
}
