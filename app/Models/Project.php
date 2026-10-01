<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Translatable;

    protected $fillable = [
        'title_en', 'title_km', 'description_en', 'description_km',
        'content_en', 'content_km',
        'thumbnail', 'gallery', 'video_url', 'video_file',
        'url', 'github_url', 'technologies',
        'is_featured', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'technologies' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /** Convert a YouTube/Vimeo link into an <iframe> embed URL. */
    public function getVideoEmbedUrlAttribute(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        if (preg_match('~(?:youtu\.be/|v=|embed/)([\w-]{11})~', $this->video_url, $m)) {
            return "https://www.youtube.com/embed/{$m[1]}";
        }

        if (preg_match('~vimeo\.com/(\d+)~', $this->video_url, $m)) {
            return "https://player.vimeo.com/video/{$m[1]}";
        }

        return null;
    }
}
