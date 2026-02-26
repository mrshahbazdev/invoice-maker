<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\EmailTemplate;

class EmailTemplates extends Component
{
    public $templates = [];
    public $showModal = false;

    public $template_id = null;
    public $name = '';
    public $subject = '';
    public $body = '';
    public $type = 'invoice';
    public $is_default = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'body' => 'required|string',
        'type' => 'required|in:invoice,reminder,receipt',
    ];

    public function mount()
    {
        $this->loadTemplates();
    }

    public function render()
    {
        return view('livewire.settings.email-templates')
            ->layout('layouts.app', ['title' => __('Email Templates')]);
    }

    public function loadTemplates()
    {
        $business_id = auth()->user()->business_id;
        if ($business_id) {
            $this->templates = EmailTemplate::where('business_id', $business_id)->get();
        }
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['template_id', 'name', 'subject', 'body', 'type', 'is_default']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $template = EmailTemplate::where('business_id', auth()->user()->business_id)->findOrFail($id);

        $this->template_id = $template->id;
        $this->name = $template->name;
        $this->subject = $template->subject;
        $this->body = $template->body;
        $this->type = $template->type;
        $this->is_default = $template->is_default;

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();
        $business_id = auth()->user()->business_id;

        if ($this->is_default) {
            // Unset current default for this type
            EmailTemplate::where('business_id', $business_id)
                ->where('type', $this->type)
                ->update(['is_default' => false]);
        }

        if ($this->template_id) {
            $template = EmailTemplate::where('business_id', $business_id)->findOrFail($this->template_id);
            $template->update([
                'name' => $this->name,
                'subject' => $this->subject,
                'body' => $this->body,
                'type' => $this->type,
                'is_default' => $this->is_default,
            ]);
            session()->flash('message', __('Template updated successfully.'));
        } else {
            EmailTemplate::create([
                'business_id' => $business_id,
                'name' => $this->name,
                'subject' => $this->subject,
                'body' => $this->body,
                'type' => $this->type,
                'is_default' => $this->is_default,
            ]);
            session()->flash('message', __('Template created successfully.'));
        }

        $this->showModal = false;
        $this->loadTemplates();
    }

    public function delete($id)
    {
        $template = EmailTemplate::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $template->delete();

        session()->flash('message', __('Template deleted successfully.'));
        $this->loadTemplates();
    }

    public function setAsDefault($id)
    {
        $template = EmailTemplate::where('business_id', auth()->user()->business_id)->findOrFail($id);

        // Remove default from others of same type
        EmailTemplate::where('business_id', auth()->user()->business_id)
            ->where('type', $template->type)
            ->update(['is_default' => false]);

        $template->update(['is_default' => true]);

        $this->loadTemplates();
    }
}
