@extends('layouts.app')

@section('title', $plan->title . ' — IT Zone')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-black text-white mb-3">🌳 {{ $plan->title }}</h1>
        <p class="text-[#94a3b8]">{{ $plan->description }}</p>
        <div class="flex justify-center gap-6 mt-6 text-sm">
            <div class="neon-card px-5 py-3"><span class="neon-blue font-bold text-xl">{{ $plan->total_courses }}</span> <span class="text-[#94a3b8]">مادة</span></div>
            <div class="neon-card px-5 py-3"><span class="neon-purple font-bold text-xl">{{ $plan->total_hours }}</span> <span class="text-[#94a3b8]">ساعة معتمدة</span></div>
        </div>
    </div>

    @foreach ($levels as $level => $levelCourses)
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center font-bold text-sm"
                        style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">{{ $level }}</div>
                <h2 class="text-lg font-bold text-white">المستوى {{ $level }}</h2>
                <div class="flex-1 h-px bg-gradient-to-l from-transparent via-cyan-400/20 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($levelCourses as $course)
                    <div class="neon-card p-5">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-bold text-white leading-6">{{ $course->name }}</h3>
                            <span class="text-xs px-2 py-1 rounded-lg bg-cyan-400/10 text-cyan-300 font-mono" dir="ltr">{{ $course->code }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-[#94a3b8]">
                            <span><i class="fa-solid fa-clock ml-1"></i>{{ $course->hours }} ساعات</span>
                            @if ($course->is_required)
                                <span class="text-cyan-300">إجباري</span>
                            @else
                                <span class="text-purple-300">اختياري</span>
                            @endif
                        </div>
                        @if ($course->prerequisite_code)
                            <div class="mt-3 pt-3 border-t border-white/5 text-xs">
                                <span class="text-[#94a3b8]">يتطلب:</span>
                                <span class="text-purple-300 font-mono" dir="ltr">{{ $course->prerequisite_code }}</span>
                                @if ($course->prerequisite_note)
                                    <span class="text-[#94a3b8]">— {{ $course->prerequisite_note }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="text-center mt-12">
        <a href="{{ route('roadmaps.index') }}" class="neon-btn px-6 py-3 inline-block">
            <i class="fa-solid fa-arrow-right ml-2"></i>رجوع لجميع الخطط
        </a>
    </div>
</div>
@endsection
