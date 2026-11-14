<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TutorialCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'color', 'icon', 'sort_order'];

    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class, 'category_id');
    }
}
