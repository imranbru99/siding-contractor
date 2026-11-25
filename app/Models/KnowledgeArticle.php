<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KnowledgeArticle extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'summary', 'body', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (KnowledgeArticle $article) {
            if (blank($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
