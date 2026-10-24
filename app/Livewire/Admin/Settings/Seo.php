<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

class Seo extends Component
{
 use WithFileUploads;

 public $meta_title;
 public $meta_description;
 public $meta_keywords;

 public $og_title;
 public $og_description;
 public $new_og_image;
 public $existing_og_image;

 public $google_analytics_id;
 public $custom_header_scripts;

    protected $rules = [
        // OG image must be a real image; 2MB matches the business-logo rule.
        'new_og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|extensions:jpeg,png,jpg,gif,webp|max:2048',
    ];

 public function mount()
 {
 $this->meta_title = Setting::get('seo.meta_title', 'InvoiceMaker SaaS');
 $this->meta_description = Setting::get('seo.meta_description', 'Create and manage professional invoices easily.');
 $this->meta_keywords = Setting::get('seo.meta_keywords', 'invoice, saas, billing, creator');

 $this->og_title = Setting::get('seo.og_title', 'InvoiceMaker');
 $this->og_description = Setting::get('seo.og_description', 'The easiest way to make invoices.');
 $this->existing_og_image = Setting::get('seo.og_image');

 $this->google_analytics_id = Setting::get('seo.google_analytics_id');
 $this->custom_header_scripts = Setting::get('seo.custom_header_scripts');
 }

 public function save()
 {
        // Validate the OG image upload (previously unvalidated).
        $this->validateOnly('new_og_image');

        // Save standard text settings
 Setting::set('seo.meta_title', $this->meta_title);
 Setting::set('seo.meta_description', $this->meta_description);
 Setting::set('seo.meta_keywords', $this->meta_keywords);

 Setting::set('seo.og_title', $this->og_title);
 Setting::set('seo.og_description', $this->og_description);

 Setting::set('seo.google_analytics_id', $this->google_analytics_id);
 Setting::set('seo.custom_header_scripts', $this->custom_header_scripts);

 // Handle Image Upload
 if ($this->new_og_image) {
 $path = $this->new_og_image->store('settings', 'public');
 Setting::set('seo.og_image', $path);
 $this->existing_og_image = $path;
 $this->new_og_image = null; // reset
 }

 session()->flash('message', 'SEO settings have been successfully updated.');
 }

 public function render()
 {
 return view('livewire.admin.settings.seo')
 ->layout('layouts.admin', ['title' => 'SEO & Global Settings']);
 }
}
