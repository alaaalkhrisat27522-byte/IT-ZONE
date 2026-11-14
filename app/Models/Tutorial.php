<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tutorial extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'type', 'course_name', 'major', 'excerpt',
        'file_path', 'video_url', 'source_code_url', 'author', 'is_published',
        'downloads_count', 'views_count'
    ];

    protected $casts = ['is_published' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TutorialCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
