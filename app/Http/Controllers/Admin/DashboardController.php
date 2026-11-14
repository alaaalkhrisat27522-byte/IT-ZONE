<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\CurriculumCourse;
use App\Models\GlossaryTerm;
use App\Models\Tool;
use App\Models\Tutorial;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'tutorials' => Tutorial::count(),
            'glossary' => GlossaryTerm::count(),
            'tools' => Tool::count(),
            'achievements' => Achievement::count(),
            'courses' => CurriculumCourse::count(),
        ];

        $recentUsers = User::with('role')->latest()->take(5)->get();
        $recentTutorials = Tutorial::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentTutorials'));
    }
}
