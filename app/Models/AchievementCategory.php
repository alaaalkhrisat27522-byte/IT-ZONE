<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AchievementCategory extends Model
{
    protected $fillable = ['name', 'description', 'color', 'icon', 'sort_order'];

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'category_id');
    }
}
