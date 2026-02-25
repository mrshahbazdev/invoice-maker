<?php

namespace App\Livewire\Admin\Support;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $status = '';
    public $priority = '';
    public $search = '';
    public $category = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPriority()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function deleteTicket($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->delete();
            session()->flash('message', 'Ticket deleted successfully.');
        }
    }

    #[\Livewire\Attributes\Layout('layouts.admin')]
    public function render()
    {
        $query = Ticket::query()->with('user');

        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        if ($this->priority !== '') {
            $query->where('priority', $this->priority);
        }

        if ($this->category !== '') {
            $query->where('category', $this->category);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($uq) {
                        $uq->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%')
                            ->orWhereHas('business', function ($bq) {
                                $bq->where('name', 'like', '%' . $this->search . '%');
                            });
                    });
            });
        }

        $tickets = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('livewire.admin.support.index', [
            'tickets' => $tickets
        ]);
    }
}
