<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\TutorialCategory;
use Illuminate\Http\Request;

class TutorialsController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $type = $request->query('type');

        $tutorials = Tutorial::published()
            ->when($q, fn ($query) => $query->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                        ->orWhere('course_name', 'like', "%{$q}%")
                        ->orWhere('major', 'like', "%{$q}%");
            }))
            ->when($type, fn ($query) => $query->where('type', $type))
            ->with('category')
            ->latest()
            ->get();

        $categories = TutorialCategory::orderBy('sort_order')->get();

        return view('tutorials.index', compact('tutorials', 'categories', 'q', 'type'));
    }
}
