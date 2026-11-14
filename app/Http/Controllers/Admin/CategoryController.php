<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AchievementCategory;
use App\Models\ToolCategory;
use App\Models\TutorialCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private const TYPES = [
        'tutorials' => ['model' => TutorialCategory::class, 'label' => 'تصنيفات الشروحات', 'has_slug' => true],
        'tools' => ['model' => ToolCategory::class, 'label' => 'تصنيفات الأدوات', 'has_slug' => true],
        'achievements' => ['model' => AchievementCategory::class, 'label' => 'تصنيفات الإنجازات', 'has_slug' => false],
    ];

    public function index(string $type)
    {
        $config = self::TYPES[$type];
        $categories = $config['model']::orderBy('sort_order')->get();

        return view('admin.categories.index', compact('type', 'config', 'categories'));
    }

    public function create(string $type)
    {
        $config = self::TYPES[$type];
        return view('admin.categories.form', ['type' => $type, 'config' => $config, 'category' => null]);
    }

    public function store(Request $request, string $type)
    {
        $config = self::TYPES[$type];
        $config['model']::create($this->validated($request, $config));

        return redirect()->route('admin.categories.index', $type)->with('success', '✅ تمت إضافة التصنيف!');
    }

    public function edit(string $type, int $id)
    {
        $config = self::TYPES[$type];
        $category = $config['model']::findOrFail($id);

        return view('admin.categories.form', compact('type', 'config', 'category'));
    }

    public function update(Request $request, string $type, int $id)
    {
        $config = self::TYPES[$type];
        $config['model']::findOrFail($id)->update($this->validated($request, $config));

        return redirect()->route('admin.categories.index', $type)->with('success', '✅ تم تعديل التصنيف!');
    }

    public function destroy(string $type, int $id)
    {
        $config = self::TYPES[$type];
        $config['model']::findOrFail($id)->delete();

        return redirect()->route('admin.categories.index', $type)->with('success', '🗑️ تم حذف التصنيف!');
    }

    private function validated(Request $request, array $config): array
    {
        $rules = [
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ];
        if ($config['has_slug']) {
            $rules['slug'] = 'required|string|max:150';
        }

        $data = $request->validate($rules);
        if (! $config['has_slug']) {
            unset($data['slug']);
        }

        return $data;
    }
}
