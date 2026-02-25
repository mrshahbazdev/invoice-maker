<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount($slug)
    {
        $this->post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->with('category')
            ->firstOrFail();
    }

    public function render()
    {
        $title = $this->post->meta_title ?: $this->post->title;
        $description = $this->post->meta_description ?: $this->post->excerpt;

        return view('livewire.blog.show')
            ->layout('layouts.public', [
                'title' => $title,
                'metaDescription' => $description
            ]);
    }
}
