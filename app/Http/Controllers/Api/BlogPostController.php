<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Assuming GD driver is available

class BlogPostController
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    public function index(Request $request)
    {
        $query = Post::with('category')->orderBy('created_at', 'desc');

        if ($request->has('published')) {
            $query->where('is_published', filter_var($request->published, FILTER_VALIDATE_BOOLEAN));
        }

        $posts = $query->paginate($request->per_page ?? 15);
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'featured_image' => 'nullable|image|max:10240', // Max 10MB raw upload
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->optimizeAndStoreImage($request->file('featured_image'));
        }

        if (isset($validated['is_published']) && $validated['is_published']) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        return response()->json($post->load('category'), 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('category'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string',
            'content' => 'sometimes|required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'featured_image' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image if it exists
            if ($post->featured_image) {
                Storage::cloud()->delete($post->featured_image);
            }
            $validated['featured_image'] = $this->optimizeAndStoreImage($request->file('featured_image'));
        }

        if (isset($validated['is_published']) && $validated['is_published'] && !$post->is_published) {
            $validated['published_at'] = now();
        } elseif (isset($validated['is_published']) && !$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $post->update($validated);

        return response()->json($post->load('category'));
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::cloud()->delete($post->featured_image);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

    /**
     * Optimizes an image for SEO by resizing and compressing before storing.
     */
    protected function optimizeAndStoreImage($file): string
    {
        $filename = uniqid('blog_') . '.webp';
        $path = 'blog/' . $filename;

        // Read and process the image
        $image = $this->imageManager->read($file);

        // Resize the width to a max of 1200px while constraining proportions (aspect ratio)
        // Intervention Image v3 scaleDown achieves this automatically
        $image->scaleDown(width: 1200);

        // Encode as WebP with 80% quality for excellent compression
        $encoded = $image->toWebp(80);

        // Store the optimized image
        // We use the storage facade directly with put to write the binary string
        Storage::cloud()->put($path, (string) $encoded);

        return $path;
    }
}
