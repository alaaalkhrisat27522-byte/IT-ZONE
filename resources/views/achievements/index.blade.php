@extends('layouts.app')

@section('title', 'معرض الإنجازات — IT Zone')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-black text-white mb-4">🏆 سجل الإنجازات</h1>
        <p class="text-[#94a3b8] max-w-2xl mx-auto">مشاريع ومبادرات طلاب كلية العلوم وتقنية المعلومات — مصدر إلهامك القادم.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($achievements as $achievement)
            <div class="neon-card overflow-hidden">
                <div class="h-36 flex items-center justify-center text-5xl"
                     style="background: linear-gradient(135deg, rgba(0,212,255,0.12), rgba(188,19,254,0.12));">
                    🏆
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        @if ($achievement->category)
                            <span class="text-xs px-3 py-1 rounded-full bg-cyan-400/10 text-cyan-300">{{ $achievement->category->name }}</span>
                        @endif
                        @if ($achievement->year)
                            <span class="text-xs text-[#94a3b8]">{{ $achievement->year }}</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">{{ $achievement->title }}</h3>
                    <p class="text-[#94a3b8] text-sm leading-relaxed mb-4">{{ $achievement->description }}</p>
                    @if ($achievement->student_names)
                        <div class="text-xs text-[#94a3b8] mb-4">
                            <i class="fa-solid fa-users ml-1"></i>{{ $achievement->student_names }}
                        </div>
                    @endif
                    @if ($achievement->project_url)
                        <a href="{{ $achievement->project_url }}" target="_blank" class="neon-btn px-4 py-2 text-sm inline-block">
                            <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i>زيارة المشروع
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-[#94a3b8] py-20">لا توجد إنجازات منشورة بعد.</div>
        @endforelse
    </div>
</div>
@endsection
