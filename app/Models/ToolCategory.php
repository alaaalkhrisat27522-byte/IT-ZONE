<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ToolCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'color', 'icon', 'sort_order'];

    public function tools(): HasMany
    {
        return $this->hasMany(Tool::class, 'category_id');
    }
}
