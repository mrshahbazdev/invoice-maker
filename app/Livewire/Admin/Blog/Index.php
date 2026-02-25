<?php namespace App\Livewire\Admin\Blog; use App\Models\Post;
use Livewire\Component; class Index extends Component
{ #[\Livewire\Attributes\Layout('layouts.admin', ['title' => 'Blog Posts'])] public function render() { $posts = Post::with('category')->orderBy('created_at', 'desc')->get(); return view('livewire.admin.blog.index', ['posts' => $posts]); } public function deletePost($id) { $post = Post::find($id); if ($post) { $post->delete(); session()->flash('message', 'Post deleted successfully.'); } }
}
