<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'focus_keyword',
        'canonical_url',
        'schema_type',
        'schema_markup',
        'local_seo_city',
        'local_seo_region',
        'related_post_ids',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'schema_markup' => 'array',
        'related_post_ids' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
