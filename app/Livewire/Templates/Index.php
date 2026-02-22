<?php

namespace App\Livewire\Templates;

use Livewire\Component;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function setDefault(int $id): void
    {
        $template = Auth::user()->business->templates()->findOrFail($id);

        Auth::user()->business->templates()->update(['is_default' => false]);
        $template->update(['is_default' => true]);

        session()->flash('message', 'Default template updated.');
    }

    public function render()
    {
        $templates = Auth::user()->business->templates()->get();

        return view('livewire.templates.index', compact('templates'));
    }
}
