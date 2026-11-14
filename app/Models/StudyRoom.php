<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRoom extends Model
{
    protected $fillable = ['name', 'description', 'focus_minutes', 'break_minutes', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
