@extends('layouts.app')

@section('title', 'بنك الأدوات — IT Zone')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-black text-white mb-4">🧰 بنك الأدوات</h1>
        <p class="text-[#94a3b8] max-w-2xl mx-auto">أدوات وروابط مساعدة للطلاب — جاهزة للاستعمال فوراً.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($tools as $tool)
            <div class="neon-card p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0"
                         style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">
                        <i class="fa-solid {{ $tool->icon ?? 'fa-wrench' }}"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-1">{{ $tool->name }}</h3>
                        @if ($tool->category)
                            <span class="text-xs text-[#94a3b8]">{{ $tool->category->name }}</span>
                        @endif
                    </div>
                </div>
                <p class="text-[#94a3b8] text-sm leading-relaxed mb-5">{{ $tool->description }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs px-3 py-1 rounded-full {{ $tool->is_free ? 'bg-green-400/10 text-green-300' : 'bg-amber-400/10 text-amber-300' }}">
                        {{ $tool->is_free ? 'مجاني' : 'مدفوع' }}
                    </span>
                    @if ($tool->url)
                        <a href="{{ $tool->url }}" target="_blank" class="neon-btn px-4 py-2 text-sm">
                            زيارة <i class="fa-solid fa-arrow-up-right-from-square mr-1 text-xs"></i>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-[#94a3b8] py-20">لا توجد أدوات بعد.</div>
        @endforelse
    </div>
</div>
@endsection
