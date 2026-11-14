@extends('layouts.app')

@section('title', 'ويكي التخصصات — IT Zone')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-black text-white mb-4">🗺️ شجرة التخصصات</h1>
        <p class="text-[#94a3b8] max-w-2xl mx-auto">خطط دراسية كاملة مع شجرة المتطلبات — اعرف مسارك من أول مادة لمشروع التخرج.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        @forelse ($plans as $plan)
            <a href="{{ route('roadmaps.show', $plan->plan_ref) }}" class="neon-card p-8 block">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-2">{{ $plan->title }}</h3>
                        <p class="text-[#94a3b8] text-sm">{{ $plan->major }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl"
                            style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">🎓</div>
                </div>
                <p class="text-[#94a3b8] text-sm leading-relaxed mb-6">{{ $plan->description }}</p>
                <div class="flex gap-6 text-sm">
                    <div><span class="neon-blue font-bold text-lg">{{ $plan->courses_count }}</span> <span class="text-[#94a3b8]">مادة</span></div>
                    <div><span class="neon-purple font-bold text-lg">{{ $plan->total_hours }}</span> <span class="text-[#94a3b8]">ساعة</span></div>
                </div>
            </a>
        @empty
            <div class="col-span-2 text-center text-[#94a3b8] py-20">لا توجد خطط بعد.</div>
        @endforelse
    </div>
</div>
@endsection
