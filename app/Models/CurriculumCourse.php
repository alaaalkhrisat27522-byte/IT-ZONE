<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurriculumCourse extends Model
{
    protected $fillable = [
        'plan_id', 'plan_ref', 'name', 'code', 'hours',
        'prerequisite_code', 'prerequisite_name', 'prerequisite_note',
        'category', 'is_required', 'major'
    ];

    protected $casts = ['is_required' => 'boolean'];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(AcademicPlan::class, 'plan_id');
    }
}
