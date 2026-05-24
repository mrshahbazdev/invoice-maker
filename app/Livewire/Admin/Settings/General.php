<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class General extends Component
{
 use \Livewire\WithFileUploads;

 public $site_name;
 public $logo;
 public $favicon;
 public $current_logo;
 public $current_favicon;

 public function mount()
 {
 $this->site_name = \App\Models\Setting::get('site.name', config('app.name'));
 $this->current_logo = \App\Models\Setting::get('site.logo');
 $this->current_favicon = \App\Models\Setting::get('site.favicon');
 }

 public function updatedLogo()
 {
 $this->validate([
 'logo' => 'image|max:2048', // 2MB Max
 ]);
 }

 public function updatedFavicon()
 {
 $this->validate([
 'favicon' => 'image|max:1024', // 1MB Max
 ]);
 }

 public function save()
 {
 $this->validate([
 'site_name' => 'required|string|max:255',
 'logo' => 'nullable|image|max:2048',
 'favicon' => 'nullable|image|max:1024',
 ]);

 \App\Models\Setting::set('site.name', $this->site_name);

 if ($this->logo) {
 $path = $this->logo->store('branding', 'public');
 \App\Models\Setting::set('site.logo', $path);
 $this->current_logo = $path;
 }

 if ($this->favicon) {
 $path = $this->favicon->store('branding', 'public');
 \App\Models\Setting::set('site.favicon', $path);
 $this->current_favicon = $path;
 }

 session()->flash('message', 'Global settings updated successfully.');
 }

 public function render()
 {
 return view('livewire.admin.settings.general')->layout('layouts.admin', ['title' => 'Global Branding Settings']);
 }
}
