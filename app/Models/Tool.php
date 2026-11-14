<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tool extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'url', 'icon', 'is_free', 'is_approved', 'approved_by'];

    protected $casts = ['is_free' => 'boolean', 'is_approved' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ToolCategory::class, 'category_id');
    }
}
