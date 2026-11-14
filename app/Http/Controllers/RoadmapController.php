<?php

namespace App\Http\Controllers;

use App\Models\AcademicPlan;
use App\Models\CurriculumCourse;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    public function index()
    {
        $plans = AcademicPlan::withCount('courses')->get();
        return view('roadmaps.index', compact('plans'));
    }

    public function show(string $plan_ref)
    {
        $plan = AcademicPlan::where('plan_ref', $plan_ref)->firstOrFail();
        $courses = CurriculumCourse::where('plan_id', $plan->id)->get();

        // ترتيب المواد على شكل مستويات (الشجرة)
        $byCode = $courses->keyBy('code');
        $memo = [];
        $levels = [];
        foreach ($courses as $course) {
            $level = $this->courseLevel($course, $byCode, $memo);
            $levels[$level][] = $course;
        }
        ksort($levels);

        return view('roadmaps.show', compact('plan', 'courses', 'levels'));
    }

    private function courseLevel($course, $byCode, &$memo)
    {
        if (! $course->prerequisite_code) {
            return 1;
        }
        if (isset($memo[$course->code])) {
            return $memo[$course->code];
        }
        $parent = $byCode[$course->prerequisite_code] ?? null;
        $level = 1 + ($parent ? $this->courseLevel($parent, $byCode, $memo) : 0);
        $memo[$course->code] = $level;
        return $level;
    }
}
