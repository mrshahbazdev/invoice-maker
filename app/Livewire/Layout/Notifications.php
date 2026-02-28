<?php

namespace App\Livewire\Layout;

use Livewire\Component;

use App\Models\User;

class Notifications extends Component
{
    public $unreadNotifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->unreadNotifications = $user->unreadNotifications()->take(5)->get();
            $this->unreadCount = $user->unreadNotifications()->count();
        }
    }

    public function markAsRead($id, $url = null)
    {
        if (auth()->check()) {
            $notification = auth()->user()->notifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        if ($url) {
            return redirect()->to($url);
        }

        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.layout.notifications');
    }
}
