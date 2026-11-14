<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolCategory;

class ToolsController extends Controller
{
    public function index()
    {
        $tools = Tool::where('is_approved', true)->with('category')->latest()->get();
        $categories = ToolCategory::orderBy('sort_order')->get();

        return view('tools.index', compact('tools', 'categories'));
    }
}
