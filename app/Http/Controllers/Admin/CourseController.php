<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicPlan;
use App\Models\CurriculumCourse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $courses = CurriculumCourse::when($q, fn ($query) => $query->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")->orWhere('code', 'like', "%{$q}%");
            }))
            ->orderBy('code')
            ->get();

        return view('admin.courses.index', compact('courses', 'q'));
    }

    public function create()
    {
        $plans = AcademicPlan::all();
        return view('admin.courses.form', ['course' => null, 'plans' => $plans]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $plan = AcademicPlan::findOrFail($request->plan_id);
        $data['plan_id'] = $plan->id;
        $data['plan_ref'] = $plan->plan_ref;

        CurriculumCourse::create($data);

        return redirect()->route('admin.courses.index')->with('success', '✅ تمت إضافة المادة!');
    }

    public function edit(CurriculumCourse $course)
    {
        $plans = AcademicPlan::all();
        return view('admin.courses.form', compact('course', 'plans'));
    }

    public function update(Request $request, CurriculumCourse $course)
    {
        $data = $this->validated($request, $course->id);
        $plan = AcademicPlan::findOrFail($request->plan_id);
        $data['plan_id'] = $plan->id;
        $data['plan_ref'] = $plan->plan_ref;

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', '✅ تم تعديل المادة!');
    }

    public function destroy(CurriculumCourse $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', '🗑️ تم حذف المادة!');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'plan_id' => 'required|exists:academic_plans,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:30|unique:curriculum_courses,code,' . ($id ?? 'NULL'),
            'hours' => 'required|integer|min:1|max:10',
            'prerequisite_code' => 'nullable|string|max:30',
            'prerequisite_name' => 'nullable|string|max:255',
            'prerequisite_note' => 'nullable|string|max:255',
            'category' => 'required|in:university,faculty,college,major,elective',
            'major' => 'nullable|string|max:150',
        ]);
    }
}
