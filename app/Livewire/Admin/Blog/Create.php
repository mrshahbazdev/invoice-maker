<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
 use WithFileUploads;

 public $title, $slug, $category_id, $excerpt, $content, $meta_title, $meta_description;
 public $is_published = false;
 public $featured_image;

 #[\Livewire\Attributes\Layout('layouts.admin', ['title' => 'Create Post'])]
 public function render()
 {
 return view('livewire.admin.blog.create', [
 'categories' => Category::orderBy('name')->get()
 ]);
 }

 public function updatedTitle()
 {
 if (empty($this->slug)) {
 $this->slug = Str::slug($this->title);
 }
 }

 public function save()
 {
 $this->validate([
 'title' => 'required|string|max:255',
 'slug' => 'required|string|max:255|unique:posts,slug',
 'category_id' => 'nullable|exists:categories,id',
 'content' => 'required|string',
 'excerpt' => 'nullable|string',
 'meta_title' => 'nullable|string|max:255',
 'meta_description' => 'nullable|string',
 'is_published' => 'boolean',
 'featured_image' => 'nullable|image|max:2048',
 ]);

 $imagePath = null;
 if ($this->featured_image) {
 $imagePath = $this->featured_image->store('blog/images', 'public');
 }

 Post::create([
 'title' => $this->title,
 'slug' => Str::slug($this->slug),
 'category_id' => $this->category_id === '' ? null : $this->category_id,
 'content' => $this->content,
 'excerpt' => $this->excerpt,
 'meta_title' => $this->meta_title,
 'meta_description' => $this->meta_description,
 'is_published' => $this->is_published,
 'published_at' => $this->is_published ? now() : null,
 'featured_image' => $imagePath,
 ]);

 session()->flash('message', 'Post created successfully.');
 return $this->redirect(route('admin.blog.index'), navigate: true);
 }
}
