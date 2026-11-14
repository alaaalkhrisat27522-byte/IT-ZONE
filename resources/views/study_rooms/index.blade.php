@extends('layouts.app')

@section('title', 'غرف الدراسة — IT Zone')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-black text-white mb-4">⏱️ غرف البومودورو الجماعية</h1>
        <p class="text-[#94a3b8] max-w-2xl mx-auto">ادخل غرفة، ادرس مع زملائك بنفس العداد — تركيز أعلى وحماس أكثر!</p>
    </div>

    @if (session('success'))
        <div class="max-w-2xl mx-auto mb-6 p-4 rounded-lg border border-green-400/30 bg-green-400/10 text-green-300 text-sm">{{ session('success') }}</div>
    @endif

    @auth
        @if (auth()->user()->isAdmin())
            <form method="POST" action="{{ route('study-rooms.store') }}" class="neon-card p-6 max-w-2xl mx-auto mb-10">
                @csrf
                <h3 class="font-bold text-white mb-4"><i class="fa-solid fa-plus ml-2 neon-blue"></i>إنشاء غرفة جديدة</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="name" placeholder="اسم الغرفة" class="neon-input px-4 py-3 md:col-span-2" required>
                    <input type="text" name="description" placeholder="وصف (اختياري)" class="neon-input px-4 py-3 md:col-span-2">
                    <div>
                        <label class="block text-xs text-[#94a3b8] mb-1">دقائق التركيز</label>
                        <input type="number" name="focus_minutes" value="25" min="1" max="120" class="neon-input px-4 py-3 w-full" required>
                    </div>
                    <div>
                        <label class="block text-xs text-[#94a3b8] mb-1">دقائق الراحة</label>
                        <input type="number" name="break_minutes" value="5" min="1" max="60" class="neon-input px-4 py-3 w-full" required>
                    </div>
                </div>
                <button class="neon-btn px-6 py-2.5 mt-4 font-bold">إنشاء 🚀</button>
            </form>
        @endif
    @endauth

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($rooms as $room)
            <div class="neon-card p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-bold text-white">{{ $room->name }}</h3>
                    <span class="text-xs px-3 py-1 rounded-full bg-green-400/10 text-green-300">● نشطة</span>
                </div>
                <p class="text-[#94a3b8] text-sm mb-5">{{ $room->description }}</p>
                <div class="flex items-center gap-4 text-xs text-[#94a3b8] mb-5">
                    <span><i class="fa-solid fa-brain ml-1"></i>{{ $room->focus_minutes }} دقيقة تركيز</span>
                    <span><i class="fa-solid fa-mug-hot ml-1"></i>{{ $room->break_minutes }} دقيقة راحة</span>
                </div>
                <a href="{{ route('study-rooms.show', $room) }}" class="neon-btn px-5 py-2.5 text-sm font-bold inline-block">
                    <i class="fa-solid fa-door-open ml-2"></i>ادخل الغرفة
                </a>
            </div>
        @empty
            <div class="col-span-3 text-center text-[#94a3b8] py-20">لا توجد غرف بعد.</div>
        @endforelse
    </div>
</div>
@endsection
