@extends('layouts.app')

@section('title', 'انضم إلينا — IT Zone')

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="neon-card p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4"
                 style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">
                <i class="fa-solid fa-rocket"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">إنشاء حساب جديد</h1>
            <p class="text-[#94a3b8] text-sm mt-2">انضم إلى مجتمع IT Zone</p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm mb-6">
                <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-[#94a3b8] mb-2">الاسم الكامل</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" class="neon-input w-full px-4 py-3" required autofocus>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#94a3b8] mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#94a3b8] mb-2">كلمة المرور (8 أحرف على الأقل)</label>
                <input type="password" name="password" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#94a3b8] mb-2">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>

            <button type="submit" class="neon-btn w-full py-3.5 font-bold text-center">
                <i class="fa-solid fa-user-plus ml-2"></i>إنشاء الحساب
            </button>
        </form>

        <p class="text-center text-[#94a3b8] text-sm mt-6">
            عندك حساب؟
            <a href="{{ route('auth.login') }}" class="neon-blue hover:text-white transition">سجّل دخول</a>
        </p>
    </div>
</div>
@endsection
