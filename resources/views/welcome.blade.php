@extends('layouts.app')

@section('title', 'IT Zone — منصة طلاب كلية تكنولوجيا المعلومات')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#00d4ff]/8 via-transparent to-[#bc13fe]/8"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="inline-block px-5 py-2.5 rounded-full glass border border-white/10 mb-8">
                <span class="text-[#00d4ff] text-sm font-semibold">
                    <i class="fa-solid fa-graduation-cap ml-2"></i>
                    جامعة الزرقاء — كلية تكنولوجيا المعلومات
                </span>
            </div>

            <h1 class="text-4xl md:text-7xl font-black text-white mb-6 leading-tight">
                مرحباً بكم في <span class="neon-text">IT Zone</span>
            </h1>

            <p class="text-xl text-[#94a3b8] mb-8 max-w-3xl mx-auto leading-relaxed">
                منصة طلاب كلية تكنولوجيا المعلومات — جامعة الزرقاء. كل ما تحتاجه في مكان واحد.
            </p>

            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('roadmaps.index') }}" class="neon-btn px-8 py-4 rounded-xl text-lg font-bold">
                    <i class="fa-solid fa-map-location-dot ml-2"></i>
                    🗺️ شجرة التخصصات
                </a>
                <a href="{{ route('glossary.index') }}" class="neon-btn px-8 py-4 rounded-xl text-lg font-bold">
                    <i class="fa-solid fa-brain ml-2"></i>
                    📚 ويكي التخصصات
                </a>
            </div>
        </div>
    </section>

    <!-- Sections Grid -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <a href="{{ route('roadmaps.index') }}" class="neon-card p-8 block">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-6" style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">🗺️</div>
                    <h3 class="text-xl font-bold text-white mb-3">شجرة التخصصات</h3>
                    <p class="text-[#94a3b8] text-sm leading-relaxed">
                        خرائط ذكية (AI) لمواد تخصص هندسة الحاسوب — خطة 2025/2026 مع شجرة المتطلبات.
                    </p>
                </a>

                <a href="{{ route('tutorials.index') }}" class="neon-card p-8 block">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-6" style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">🎓</div>
                    <h3 class="text-xl font-bold text-white mb-3">أكاديمية البرمجة</h3>
                    <p class="text-[#94a3b8] text-sm leading-relaxed">
                        شروحات ودروس مصورة — Python, C++, JavaScript. شريط بحث لحظي + خرائط ذهنية.
                    </p>
                </a>

                <a href="{{ route('study-rooms.index') }}" class="neon-card p-8 block">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-6" style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">⏱️</div>
                    <h3 class="text-xl font-bold text-white mb-3">غرفة الدراسة فزعة </h3>
                    <p class="text-[#94a3b8] text-sm leading-relaxed">
                        نظام 25/5 مخصص — مزامنة كاملة لجميع الغرف، تتبع الحضور ودرجات التركيز.
                    </p>
                </a>

                <a href="{{ route('achievements.index') }}" class="neon-card p-8 block">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-6" style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">🏆</div>
                    <h3 class="text-xl font-bold text-white mb-3">سجل الإنجازات</h3>
                    <p class="text-[#94a3b8] text-sm leading-relaxed">
                        إنجازات الطلاب موثقة — تصفح أفكار مشاريع التخرج وقيد الإنجازات.
                    </p>
                </a>

                <a href="{{ route('tools.index') }}" class="neon-card p-8 block">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-6" style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">🧰</div>
                    <h3 class="text-xl font-bold text-white mb-3">صندوق الأدوات</h3>
                    <p class="text-[#94a3b8] text-sm leading-relaxed">
                        أدوات وروابط ومواقع مساعدة للطلاب — استعراض مباشر + إضافة أدوات جديدة.
                    </p>
                </a>

                <a href="{{ route('glossary.index') }}" class="neon-card p-8 block">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-6" style="background: linear-gradient(135deg, #00d4ff, #bc13fe);">📚</div>
                    <h3 class="text-xl font-bold text-white mb-3">ويكي التخصصات</h3>
                    <p class="text-[#94a3b8] text-sm leading-relaxed">
                        مصطلحات تقنية معروضة بشكل مبسط — بحث حقيقي في الوقت الحقيقي.
                    </p>
                </a>

            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-16 border-t border-white/5">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-black text-[#00d4ff] mb-2">6</div>
                    <div class="text-[#94a3b8] text-sm">أقسام رئيسية</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-[#bc13fe] mb-2">331</div>
                    <div class="text-[#94a3b8] text-sm">مادة دراسية</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-[#00d4ff] mb-2">1,200+</div>
                    <div class="text-[#94a3b8] text-sm">مطالب دراسية</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-[#bc13fe] mb-2">24/7</div>
                    <div class="text-[#94a3b8] text-sm">مساعد ذكي</div>
                </div>
            </div>
        </div>
    </section>
@endsection
