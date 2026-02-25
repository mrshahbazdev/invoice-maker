<?php namespace App\Livewire\Blog; use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination; class Index extends Component
{ use WithPagination; public $category = null; public function mount($category = null) { $this->category = $category; } #[\Livewire\Attributes\Layout('layouts.public', ['title' => 'Blog'])] public function render() { $query = Post::where('is_published', true)->orderBy('published_at', 'desc'); if ($this->category) { $query->whereHas('category', function ($q) { $q->where('slug', $this->category); }); } $posts = $query->paginate(12); $categories = Category::withCount([ 'posts' => function ($q) { $q->where('is_published', true); } ])->having('posts_count', '>', 0)->get(); return view('livewire.blog.index', [ 'posts' => $posts, 'categories' => $categories ]); }
}
