<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlossaryTerm extends Model
{
    protected $fillable = [
        'term', 'slug', 'short_definition', 'detailed_definition',
        'major', 'related_majors', 'example', 'difficulty', 'is_featured'
    ];

    protected $casts = ['related_majors' => 'array', 'is_featured' => 'boolean'];
}
