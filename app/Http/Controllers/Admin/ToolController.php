<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\ToolCategory;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::with('category')->latest()->get();
        return view('admin.tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = ToolCategory::orderBy('sort_order')->get();
        return view('admin.tools.form', ['tool' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        Tool::create($this->validated($request) + [
            'is_free' => $request->boolean('is_free'),
            'is_approved' => $request->boolean('is_approved'),
            'approved_by' => $request->boolean('is_approved') ? auth()->id() : null,
        ]);

        return redirect()->route('admin.tools.index')->with('success', '✅ تمت إضافة الأداة!');
    }

    public function edit(Tool $tool)
    {
        $categories = ToolCategory::orderBy('sort_order')->get();
        return view('admin.tools.form', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $tool->update($this->validated($request, $tool->id) + [
            'is_free' => $request->boolean('is_free'),
            'is_approved' => $request->boolean('is_approved'),
            'approved_by' => $request->boolean('is_approved') ? auth()->id() : null,
        ]);

        return redirect()->route('admin.tools.index')->with('success', '✅ تم تعديل الأداة!');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return redirect()->route('admin.tools.index')->with('success', '🗑️ تم حذف الأداة!');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:190|unique:tools,slug,' . ($id ?? 'NULL'),
            'category_id' => 'nullable|exists:tool_categories,id',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:500',
            'icon' => 'nullable|string|max:50',
        ]);
    }
}
