<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'IT Zone | فريق تكنولوجيا المعلومات')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');

        :root {
            --bg: #05050a;
            --panel: #0d1022;
            --panel-2: #12162f;
            --blue: #00d4ff;
            --purple: #bc13fe;
            --text: #e2e8f0;
            --muted: #8b93b8;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--bg);
            color: var(--text);
        }

        .neon-text {
            background: linear-gradient(90deg, var(--blue), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .neon-blue { color: var(--blue); text-shadow: 0 0 10px rgba(0, 212, 255, 0.6), 0 0 20px rgba(0, 212, 255, 0.35); }
        .neon-purple { color: var(--purple); text-shadow: 0 0 10px rgba(188, 19, 254, 0.6), 0 0 20px rgba(188, 19, 254, 0.35); }

        .neon-card {
            background: linear-gradient(160deg, rgba(13, 16, 34, 0.95), rgba(18, 22, 47, 0.9));
            border: 1px solid rgba(0, 212, 255, 0.18);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        .neon-card:hover {
            border-color: rgba(188, 19, 254, 0.55);
            box-shadow: 0 0 30px rgba(188, 19, 254, 0.22), 0 0 45px rgba(0, 212, 255, 0.12);
            transform: translateY(-4px);
        }

        .neon-btn {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.16), rgba(188, 19, 254, 0.2));
            border: 1px solid rgba(0, 212, 255, 0.5);
            color: var(--blue);
            border-radius: 0.9rem;
            transition: all 0.3s ease;
        }
        .neon-btn:hover {
            background: linear-gradient(135deg, var(--blue), var(--purple));
            color: #05050a;
            box-shadow: 0 0 25px rgba(0, 212, 255, 0.5);
        }

        .neon-input {
            background: rgba(13, 16, 34, 0.9);
            border: 1px solid rgba(0, 212, 255, 0.25);
            border-radius: 0.8rem;
            color: var(--text);
        }
        .neon-input:focus {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 18px rgba(188, 19, 254, 0.35);
        }

        .hero-glow {
            background:
                radial-gradient(ellipse 60% 50% at 20% 0%, rgba(0, 212, 255, 0.14), transparent),
                radial-gradient(ellipse 55% 45% at 85% 10%, rgba(188, 19, 254, 0.14), transparent);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen relative overflow-x-hidden">
<div class="hero-glow min-h-screen flex flex-col">

    {{-- ===== شريط التنقل الرئيسي ===== --}}
    <nav class="border-b border-cyan-400/10 backdrop-blur-md sticky top-0 z-40 bg-[#05050a]/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-lg"
                         style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">IT</div>
                    <div>
                        <div class="font-bold text-lg leading-5">IT Zone</div>
                        <div class="text-[11px] text-slate-400 leading-3">جامعة الزرقاء — كلية العلوم وتقنية المعلومات</div>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-1">
                    @php
                        $navLinks = [
                            ['route' => 'home', 'label' => 'الرئيسية', 'icon' => 'fa-house'],
                            ['route' => 'roadmaps.index', 'label' => 'ويكي التخصصات', 'icon' => 'fa-diagram-project'],
                            ['route' => 'tutorials.index', 'label' => 'الشروحات والخرائط', 'icon' => 'fa-book-open'],
                            ['route' => 'study-rooms.index', 'label' => 'غرف الدراسة', 'icon' => 'fa-clock'],
                            ['route' => 'achievements.index', 'label' => 'معرض الإنجازات', 'icon' => 'fa-trophy'],
                            ['route' => 'tools.index', 'label' => 'بنك الأدوات', 'icon' => 'fa-toolbox'],
                            ['route' => 'glossary.index', 'label' => 'قاموس السنافر', 'icon' => 'fa-spell-check'],
                        ];
                    @endphp
                    @foreach ($navLinks as $link)
                        @php $active = request()->routeIs($link['route'] === 'home' ? 'home' : $link['route'] . '*'); @endphp
                        <a href="{{ route($link['route']) }}"
                           class="px-3.5 py-2 rounded-lg text-sm transition flex items-center gap-1.5 {{ $active ? 'text-cyan-300 bg-cyan-400/10' : 'hover:text-cyan-300 hover:bg-white/5' }}">
                            <i class="fa-solid {{ $link['icon'] }} text-[11px] opacity-70"></i>{{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}"
                           class="neon-btn px-4 py-2 text-sm font-semibold hidden sm:flex items-center gap-2">
                            <i class="fa-solid {{ auth()->user()->isSuperAdmin() ? 'fa-crown' : (auth()->user()->isAdmin() ? 'fa-shield-halved' : 'fa-graduation-cap') }}"></i>
                            {{ auth()->user()->full_name }}
                        </a>
                        <form action="{{ route('auth.logout') }}" method="POST" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg text-sm border border-[#1a1a2e] text-slate-300 hover:text-white hover:border-red-500/50 transition">
                                <i class="fa-solid fa-right-from-bracket ml-1"></i>خروج
                            </button>
                        </form>
                    @else
                        <a href="{{ route('auth.login') }}" class="px-4 py-2 rounded-lg text-sm text-slate-300 hover:text-cyan-300 hover:bg-white/5 transition hidden sm:block">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('auth.register') }}" class="neon-btn px-5 py-2 text-sm font-semibold">
                            <i class="fa-solid fa-rocket ml-1"></i>انضم إلينا
                        </a>
                    @endauth

                    <button id="mobile-menu-btn" class="lg:hidden w-10 h-10 rounded-lg border border-cyan-400/20 text-cyan-300 hover:bg-white/5 transition">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="lg:hidden hidden border-t border-cyan-400/10 bg-[#05050a]/95 px-4 py-3">
            @foreach ($navLinks as $link)
                @php $active = request()->routeIs($link['route'] === 'home' ? 'home' : $link['route'] . '*'); @endphp
                <a href="{{ route($link['route']) }}"
                   class="block px-4 py-2.5 rounded-lg text-sm transition {{ $active ? 'text-cyan-300 bg-cyan-400/10' : 'text-slate-300 hover:text-cyan-300 hover:bg-white/5' }}">
                    <i class="fa-solid {{ $link['icon'] }} ml-2 text-[11px] opacity-70"></i>{{ $link['label'] }}
                </a>
            @endforeach
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="block px-4 py-2.5 rounded-lg text-sm text-cyan-300 hover:bg-white/5">
                    <i class="fa-solid fa-user ml-2 text-[11px]"></i>{{ auth()->user()->full_name }}
                </a>
                <form action="{{ route('auth.logout') }}" method="POST">@csrf
                    <button type="submit" class="w-full text-right px-4 py-2.5 rounded-lg text-sm text-red-300 hover:bg-white/5">
                        <i class="fa-solid fa-right-from-bracket ml-2 text-[11px]"></i>تسجيل الخروج
                    </button>
                </form>
            @else
                <a href="{{ route('auth.login') }}" class="block px-4 py-2.5 rounded-lg text-sm text-slate-300 hover:bg-white/5">
                    <i class="fa-solid fa-right-to-bracket ml-2 text-[11px]"></i>تسجيل الدخول
                </a>
            @endauth
        </div>
    </nav>

    <script>
        (function () {
            var btn = document.getElementById('mobile-menu-btn');
            var menu = document.getElementById('mobile-menu');
            if (btn && menu) btn.addEventListener('click', function () { menu.classList.toggle('hidden'); });
        })();
    </script>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-cyan-400/10 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center font-black"
                             style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">IT</div>
                        <div class="font-bold">IT Zone</div>
                    </div>
                    <p class="text-slate-400 text-sm leading-7">
                        منصة طلاب كلية تكنولوجيا المعلومات — جامعة الزرقاء.
                        ويكي التخصصات، المساعد الذكي، الشروحات، وغرف الدراسة.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 neon-blue">روابط سريعة</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('roadmaps.index') }}" class="hover:text-cyan-300 transition">ويكي التخصصات (IT Roadmaps)</a></li>
                        <li><a href="{{ route('tutorials.index') }}" class="hover:text-cyan-300 transition">أكاديمية الشروحات والخرائط الذهنية</a></li>
                        <li><a href="{{ route('study-rooms.index') }}" class="hover:text-cyan-300 transition">غرف الدراسة المشتركة</a></li>
                        <li><a href="{{ route('achievements.index') }}" class="hover:text-cyan-300 transition">معرض الإنجازات</a></li>
                        <li><a href="{{ route('tools.index') }}" class="hover:text-cyan-300 transition">بنك الأدوات</a></li>
                        <li><a href="{{ route('glossary.index') }}" class="hover:text-cyan-300 transition">قاموس السنافر</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 neon-purple">مساعد IT Zone الذكي</h4>
                    <p class="text-slate-400 text-sm leading-7">
                        اضغط على أيقونة الدردشة في الزاوية لطرح أسئلة التسجيل، أو لمراجعة كودك، أو لطلب فكرة مشروع.
                    </p>
                </div>
            </div>
            <div class="border-t border-white/5 mt-8 pt-6 text-center text-slate-500 text-xs">
                © {{ date('Y') }} IT Zone — جميع الحقوق محفوظة
            </div>
        </div>
    </footer>
</div>
@include('partials.ai_chat_widget')

@stack('scripts')
</body>
</html>
