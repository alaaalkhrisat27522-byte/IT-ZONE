<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlossaryTerm;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    public function index()
    {
        $terms = GlossaryTerm::orderBy('term')->get();
        return view('admin.glossary.index', compact('terms'));
    }

    public function create()
    {
        return view('admin.glossary.form', ['term' => null]);
    }

    public function store(Request $request)
    {
        GlossaryTerm::create($this->validated($request));

        return redirect()->route('admin.glossary.index')->with('success', '✅ تمت إضافة المصطلح!');
    }

    public function edit(GlossaryTerm $term)
    {
        return view('admin.glossary.form', compact('term'));
    }

    public function update(Request $request, GlossaryTerm $term)
    {
        $term->update($this->validated($request, $term->id));

        return redirect()->route('admin.glossary.index')->with('success', '✅ تم تعديل المصطلح!');
    }

    public function destroy(GlossaryTerm $term)
    {
        $term->delete();

        return redirect()->route('admin.glossary.index')->with('success', '🗑️ تم حذف المصطلح!');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'term' => 'required|string|max:150',
            'slug' => 'required|string|max:190|unique:glossary_terms,slug,' . ($id ?? 'NULL'),
            'short_definition' => 'required|string|max:500',
            'detailed_definition' => 'nullable|string',
            'major' => 'nullable|string|max:150',
            'example' => 'nullable|string',
            'difficulty' => 'required|in:مبتدئ,متوسط,متقدم',
        ]);

        // التخصصات المرتبة: نص مفصول بفواصل ← مصفوفة
        $data['related_majors'] = array_values(array_filter(array_map('trim', explode(',', $request->input('related_majors', '')))));
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
