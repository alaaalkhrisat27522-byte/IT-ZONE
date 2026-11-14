<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::with('category')->latest()->get();
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        $categories = AchievementCategory::orderBy('sort_order')->get();
        return view('admin.achievements.form', ['achievement' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_visible'] = $request->boolean('is_visible');

        if ($request->hasFile('project_image')) {
            $data['project_image'] = $request->file('project_image')->store('achievements', 'public');
        }

        Achievement::create($data);

        return redirect()->route('admin.achievements.index')->with('success', '✅ تمت إضافة الإنجاز!');
    }

    public function edit(Achievement $achievement)
    {
        $categories = AchievementCategory::orderBy('sort_order')->get();
        return view('admin.achievements.form', compact('achievement', 'categories'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $data = $this->validated($request, $achievement->id);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_visible'] = $request->boolean('is_visible');

        if ($request->hasFile('project_image')) {
            if ($achievement->project_image) {
                Storage::disk('public')->delete($achievement->project_image);
            }
            $data['project_image'] = $request->file('project_image')->store('achievements', 'public');
        }

        $achievement->update($data);

        return redirect()->route('admin.achievements.index')->with('success', '✅ تم تعديل الإنجاز!');
    }

    public function toggle(Achievement $achievement)
    {
        $achievement->update(['is_visible' => ! $achievement->is_visible]);

        return back()->with('success', $achievement->is_visible ? '✅ أصبح الإنجاز ظاهراً!' : '🙈 تم إخفاء الإنجاز!');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->project_image) {
            Storage::disk('public')->delete($achievement->project_image);
        }
        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', '🗑️ تم حذف الإنجاز!');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:190|unique:achievements,slug,' . ($id ?? 'NULL'),
            'description' => 'nullable|string',
            'student_names' => 'nullable|string',
            'category_id' => 'nullable|exists:achievement_categories,id',
            'project_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'project_url' => 'nullable|url|max:500',
            'major' => 'nullable|string|max:150',
            'year' => 'nullable|string|max:10',
        ]);
    }
}
