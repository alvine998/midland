<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'video_url',
        'section_title',
        'content',
        'vision',
        'mission',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}
