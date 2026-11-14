<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'student_names', 'category_id',
        'project_image', 'project_url', 'major', 'year', 'is_featured', 'is_visible'
    ];

    protected $casts = ['is_featured' => 'boolean', 'is_visible' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AchievementCategory::class, 'category_id');
    }
}
