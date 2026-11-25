<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'icon', 'summary', 'description',
        'starting_price', 'image_url', 'is_featured', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'starting_price' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (blank($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
