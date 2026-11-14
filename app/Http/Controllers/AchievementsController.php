<?php

namespace App\Http\Controllers;

use App\Models\Achievement;

class AchievementsController extends Controller
{
    public function index()
    {
        $achievements = Achievement::where('is_visible', true)
            ->with('category')
            ->orderByDesc('is_featured')
            ->latest()
            ->get();

        return view('achievements.index', compact('achievements'));
    }
}
