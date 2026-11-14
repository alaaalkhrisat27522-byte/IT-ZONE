<?php

namespace App\Http\Controllers;

use App\Models\StudyRoom;
use Illuminate\Http\Request;

class StudyRoomController extends Controller
{
    public function index()
    {
        $rooms = StudyRoom::where('is_active', true)->latest()->get();
        return view('study_rooms.index', compact('rooms'));
    }

    public function show(StudyRoom $studyRoom)
    {
        return view('study_rooms.show', ['room' => $studyRoom]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'focus_minutes' => 'required|integer|min:1|max:120',
            'break_minutes' => 'required|integer|min:1|max:60',
        ]);

        StudyRoom::create($data);

        return back()->with('success', '✅ تم إنشاء الغرفة!');
    }

    public function destroy(StudyRoom $studyRoom)
    {
        $studyRoom->delete();
        return back()->with('success', '🗑️ تم حذف الغرفة!');
    }
}
