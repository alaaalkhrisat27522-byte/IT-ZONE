<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicPlan extends Model
{
    protected $fillable = ['plan_ref', 'major', 'title', 'description', 'total_hours', 'total_courses', 'source'];

    public function courses(): HasMany
    {
        return $this->hasMany(CurriculumCourse::class, 'plan_id');
    }
}
