@extends('layouts.app')

@section('title', 'تسجيل الدخول — IT Zone')

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="neon-card p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4"
                style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">
                <i class="fa-solid fa-right-to-bracket"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">تسجيل الدخول</h1>
            <p class="text-[#94a3b8] text-sm mt-2">أهلاً بعودتك إلى IT Zone</p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-[#94a3b8] mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="neon-input w-full px-4 py-3" placeholder="you@example.com" dir="ltr">
            </div>

            <div>
                <label class="block text-sm font-medium text-[#94a3b8] mb-2">كلمة المرور</label>
                <input type="password" name="password" required
                        class="neon-input w-full px-4 py-3" placeholder="••••••••" dir="ltr">
            </div>

            <button type="submit" class="neon-btn w-full py-3.5 font-bold text-center">
                <i class="fa-solid fa-arrow-left-to-bracket ml-2"></i>
                دخول
            </button>
        </form>

        <p class="text-center text-[#94a3b8] text-sm mt-6">
            ما عندك حساب؟
            <a href="{{ route('auth.register') }}" class="neon-blue hover:text-white transition">انضم إلينا</a>
        </p>
    </div>
</div>
@endsection
