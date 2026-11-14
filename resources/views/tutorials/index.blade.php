@extends('layouts.app')

@section('title', 'أكاديمية الشروحات — IT Zone')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-black text-white mb-4">🎓 أكاديمية البرمجة</h1>
        <p class="text-[#94a3b8] max-w-2xl mx-auto">شروحات وملخصات وخرائط ذهنية — اضغط أي شريحة لتشاهد شروحاتنا على يوتيوب.</p>
    </div>

    <!-- شريط البحث -->
    <form method="GET" action="{{ route('tutorials.index') }}" class="max-w-2xl mx-auto mb-8">
        <div class="flex gap-3">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="🔍 ابحث عن مادة، ملخص، تخصص..."
                    class="neon-input flex-1 px-5 py-3.5">
            <select name="type" class="neon-input px-4 py-3.5">
                <option value="">الكل</option>
                <option value="summary" {{ ($type ?? '') === 'summary' ? 'selected' : '' }}>📄 ملخصات</option>
                <option value="mindmap" {{ ($type ?? '') === 'mindmap' ? 'selected' : '' }}>🗺️ خرائط ذهنية</option>
                <option value="video" {{ ($type ?? '') === 'video' ? 'selected' : '' }}>🎬 فيديو</option>
            </select>
            <button class="neon-btn px-6 py-3.5 font-bold">بحث</button>
        </div>
    </form>

    <!-- البطاقات — الضغط يفتح قناة اليوتيوب -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($tutorials as $tutorial)
            <a href="https://www.youtube.com/@IT_ZONE_ZU" target="_blank"
                class="neon-card p-6 block">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl"
                            style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">
                        {{ ['summary' => '📄', 'mindmap' => '🗺️', 'video' => '🎬'][$tutorial->type] ?? '📄' }}
                    </div>
                    @if ($tutorial->category)
                        <span class="text-xs px-3 py-1 rounded-full border border-white/10 text-[#94a3b8]">{{ $tutorial->category->name }}</span>
                    @endif
                </div>

                <h3 class="text-lg font-bold text-white mb-2 leading-7">{{ $tutorial->title }}</h3>
                <p class="text-[#94a3b8] text-sm leading-relaxed mb-4">{{ $tutorial->excerpt }}</p>

                <div class="flex items-center gap-3 text-xs text-[#94a3b8] mb-5">
                    @if ($tutorial->course_name)<span><i class="fa-solid fa-book ml-1"></i>{{ $tutorial->course_name }}</span>@endif
                    @if ($tutorial->major)<span><i class="fa-solid fa-graduation-cap ml-1"></i>{{ $tutorial->major }}</span>@endif
                </div>

                <div class="flex items-center justify-between">
                    <span class="neon-btn px-4 py-2 text-sm">
                        <i class="fa-brands fa-youtube ml-1"></i>شاهد على القناة
                    </span>
                    @if ($tutorial->file_path)
                        <span class="text-xs text-[#94a3b8]"><i class="fa-solid fa-paperclip ml-1"></i>ملف مرفق</span>
                    @endif
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center text-[#94a3b8] py-20">
                <div class="text-5xl mb-4">🔍</div>
                لا توجد نتائج لبحثك — جرّب كلمات أخرى!
            </div>
        @endforelse
    </div>

    <!-- رابط القناة -->
    <div class="text-center mt-12">
        <a href="https://www.youtube.com/@IT_ZONE_ZU" target="_blank"
            class="neon-btn px-8 py-4 inline-block font-bold text-lg">
            <i class="fa-brands fa-youtube ml-2"></i>اشترك بقناتنا — IT ZONE على يوتيوب
        </a>
    </div>
</div>
@endsection
