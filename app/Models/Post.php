<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Stringable;

class Post extends Model implements Stringable
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'is_published',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'content' => \App\Models\Casts\GrapeJsContent::class,
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if (empty($post->content)) {
                $post->content = [
                    'html' => '',
                    'css' => '',
                    'components' => [],
                    'styles' => []
                ];
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
