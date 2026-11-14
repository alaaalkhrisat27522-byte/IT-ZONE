<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use App\Models\TutorialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::with('category')->latest()->get();
        return view('admin.tutorials.index', compact('tutorials'));
    }

    public function create()
    {
        $categories = TutorialCategory::orderBy('sort_order')->get();
        return view('admin.tutorials.form', ['tutorial' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('tutorials', 'public');
        }

        Tutorial::create($data);

        return redirect()->route('admin.tutorials.index')->with('success', '✅ تمت إضافة الشرح بنجاح!');
    }

    public function edit(Tutorial $tutorial)
    {
        $categories = TutorialCategory::orderBy('sort_order')->get();
        return view('admin.tutorials.form', compact('tutorial', 'categories'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $data = $this->validated($request, $tutorial->id);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('file')) {
            if ($tutorial->file_path) {
                Storage::disk('public')->delete($tutorial->file_path);
            }
            $data['file_path'] = $request->file('file')->store('tutorials', 'public');
        }

        $tutorial->update($data);

        return redirect()->route('admin.tutorials.index')->with('success', '✅ تم تعديل الشرح بنجاح!');
    }

    public function toggle(Tutorial $tutorial)
    {
        $tutorial->update(['is_published' => ! $tutorial->is_published]);

        return back()->with('success', $tutorial->is_published ? '✅ تم نشر الشرح!' : '🙈 تم إخفاء الشرح!');
    }

    public function destroy(Tutorial $tutorial)
    {
        if ($tutorial->file_path) {
            Storage::disk('public')->delete($tutorial->file_path);
        }
        $tutorial->delete();

        return redirect()->route('admin.tutorials.index')->with('success', '🗑️ تم حذف الشرح!');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:190|unique:tutorials,slug,' . ($id ?? 'NULL'),
            'type' => 'required|in:summary,mindmap,video',
            'category_id' => 'nullable|exists:tutorial_categories,id',
            'course_name' => 'nullable|string|max:150',
            'major' => 'nullable|string|max:150',
            'excerpt' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp,gif|max:10240',
            'video_url' => 'nullable|url|max:500',
            'source_code_url' => 'nullable|url|max:500',
            'author' => 'nullable|string|max:150',
        ]);
    }
}
