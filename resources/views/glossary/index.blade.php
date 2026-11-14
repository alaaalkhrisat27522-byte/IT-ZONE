@extends('layouts.app')

@section('title', 'قاموس السنافر — IT Zone')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-black text-white mb-4">📚 ويكي التخصصات</h1>
        <p class="text-[#94a3b8] max-w-2xl mx-auto">مصطلحات تقنية معروضة بشكل مبسط — ابحث وافهم بسرعة.</p>
    </div>

    <form method="GET" action="{{ route('glossary.index') }}" class="max-w-xl mx-auto mb-10">
        <div class="flex gap-3">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="🔍 ابحث عن مصطلح..."
                   class="neon-input flex-1 px-5 py-3.5">
            <button class="neon-btn px-6 py-3.5 font-bold">بحث</button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($terms as $term)
            <div class="neon-card p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-bold neon-blue font-mono" dir="ltr">{{ $term->term }}</h3>
                    <span class="text-xs px-2.5 py-1 rounded-full border border-white/10 text-[#94a3b8]">{{ $term->difficulty }}</span>
                </div>
                <p class="text-white text-sm leading-7 mb-4">{{ $term->short_definition }}</p>
                @if ($term->example)
                    <div class="pt-3 border-t border-white/5 text-xs text-[#94a3b8]">
                        <span class="neon-purple"><i class="fa-solid fa-lightbulb ml-1"></i>مثال:</span>
                        {{ $term->example }}
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-3 text-center text-[#94a3b8] py-20">
                <div class="text-5xl mb-4">📖</div>
                لا توجد مصطلحات مطابقة.
            </div>
        @endforelse
    </div>
</div>
@endsection
