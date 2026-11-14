@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
    <!-- الإحصائيات -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        @php
            $cards = [
                ['label' => 'المستخدمون', 'value' => $stats['users'], 'icon' => 'fa-users', 'color' => '#00d4ff'],
                ['label' => 'الشروحات', 'value' => $stats['tutorials'], 'icon' => 'fa-graduation-cap', 'color' => '#bc13fe'],
                ['label' => 'مصطلحات القاموس', 'value' => $stats['glossary'], 'icon' => 'fa-spell-check', 'color' => '#00d4ff'],
                ['label' => 'الأدوات', 'value' => $stats['tools'], 'icon' => 'fa-toolbox', 'color' => '#bc13fe'],
                ['label' => 'الإنجازات', 'value' => $stats['achievements'], 'icon' => 'fa-trophy', 'color' => '#00d4ff'],
                ['label' => 'المواد الدراسية', 'value' => $stats['courses'], 'icon' => 'fa-sitemap', 'color' => '#bc13fe'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="neon-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-[#94a3b8] text-sm mb-1">{{ $card['label'] }}</div>
                        <div class="text-3xl font-black text-white">{{ $card['value'] }}</div>
                    </div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl"
                         style="background: {{ $card['color'] }}22; color: {{ $card['color'] }};">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- آخر المستخدمين + آخر الشروحات -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="neon-card p-6">
            <h2 class="font-bold text-white mb-4"><i class="fa-solid fa-users ml-2 neon-blue"></i>آخر المستخدمين</h2>
            <div class="space-y-3">
                @forelse ($recentUsers as $user)
                    <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                        <div>
                            <div class="text-sm font-semibold text-white">{{ $user->full_name }}</div>
                            <div class="text-xs text-[#94a3b8]" dir="ltr">{{ $user->email }}</div>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $user->role->slug === 'super_admin' ? 'bg-amber-400/10 text-amber-300' : ($user->role->slug === 'admin' ? 'bg-cyan-400/10 text-cyan-300' : 'bg-white/5 text-[#94a3b8]') }}">
                            {{ $user->role->name }}
                        </span>
                    </div>
                @empty
                    <div class="text-[#94a3b8] text-sm">لا يوجد مستخدمون.</div>
                @endforelse
            </div>
        </div>

        <div class="neon-card p-6">
            <h2 class="font-bold text-white mb-4"><i class="fa-solid fa-graduation-cap ml-2 neon-purple"></i>آخر الشروحات</h2>
            <div class="space-y-3">
                @forelse ($recentTutorials as $tutorial)
                    <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                        <div class="text-sm text-white">{{ $tutorial->title }}</div>
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $tutorial->is_published ? 'bg-green-400/10 text-green-300' : 'bg-white/5 text-[#94a3b8]' }}">
                            {{ $tutorial->is_published ? 'منشور' : 'مخفي' }}
                        </span>
                    </div>
                @empty
                    <div class="text-[#94a3b8] text-sm">لا توجد شروحات.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
