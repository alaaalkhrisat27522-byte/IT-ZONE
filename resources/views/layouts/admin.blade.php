<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') — IT Zone Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');
        :root { --bg: #05050a; --panel: #0d1022; --blue: #00d4ff; --purple: #bc13fe; --muted: #8b93b8; }
        body { font-family: 'Cairo', sans-serif; background: var(--bg); color: #e2e8f0; }
        .neon-text { background: linear-gradient(90deg, var(--blue), var(--purple)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .neon-blue { color: var(--blue); text-shadow: 0 0 10px rgba(0,212,255,.5); }
        .neon-purple { color: var(--purple); text-shadow: 0 0 10px rgba(188,19,254,.5); }
        .neon-card { background: linear-gradient(160deg, rgba(13,16,34,.95), rgba(18,22,47,.9)); border: 1px solid rgba(0,212,255,.18); border-radius: 1rem; transition: .3s; }
        .neon-card:hover { border-color: rgba(188,19,254,.5); box-shadow: 0 0 30px rgba(188,19,254,.18); }
        .neon-btn { background: linear-gradient(135deg, rgba(0,212,255,.16), rgba(188,19,254,.2)); border: 1px solid rgba(0,212,255,.5); color: var(--blue); border-radius: .8rem; transition: .3s; }
        .neon-btn:hover { background: linear-gradient(135deg, var(--blue), var(--purple)); color: #05050a; box-shadow: 0 0 25px rgba(0,212,255,.5); }
        .neon-input { background: rgba(13,16,34,.9); border: 1px solid rgba(0,212,255,.25); border-radius: .8rem; color: #e2e8f0; }
        .neon-input:focus { outline: none; border-color: var(--purple); box-shadow: 0 0 18px rgba(188,19,254,.35); }
        .side-link { display: flex; align-items: center; gap: .75rem; padding: .8rem 1rem; border-radius: .8rem; color: var(--muted); transition: .25s; }
        .side-link:hover { color: var(--blue); background: rgba(0,212,255,.07); }
        .side-link.active { color: var(--blue); background: rgba(0,212,255,.12); border-right: 3px solid var(--blue); }
    </style>
</head>
<body class="min-h-screen">
<div class="flex min-h-screen">

    {{-- ===== القائمة الجانبية ===== --}}
    <aside class="w-56 lg:w-64 shrink-0 border-l border-cyan-400/10 bg-[#0a0c1a]/80 p-5">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black"
                 style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">IT</div>
            <div>
                <div class="font-bold leading-5">لوحة التحكم</div>
                <div class="text-[11px] text-slate-500">IT Zone Admin</div>
            </div>
        </a>

        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie w-5"></i>لوحة التحكم
            </a>
            <a href="{{ route('admin.tutorials.index') }}" class="side-link {{ request()->routeIs('admin.tutorials.*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap w-5"></i>الشروحات
            </a>
            <a href="{{ route('admin.glossary.index') }}" class="side-link {{ request()->routeIs('admin.glossary.*') ? 'active' : '' }}">
                <i class="fa-solid fa-spell-check w-5"></i>قاموس السنافر
            </a>
            <a href="{{ route('admin.tools.index') }}" class="side-link {{ request()->routeIs('admin.tools.*') ? 'active' : '' }}">
                <i class="fa-solid fa-toolbox w-5"></i>بنك الأدوات
            </a>
            <a href="{{ route('admin.achievements.index') }}" class="side-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                <i class="fa-solid fa-trophy w-5"></i>الإنجازات
            </a>
            <a href="{{ route('admin.courses.index') }}" class="side-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sitemap w-5"></i>المواد الدراسية
            </a>
            <a href="{{ route('admin.categories.index', 'tutorials') }}" class="side-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags w-5"></i>التصنيفات
            </a>

            @if (auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}" class="side-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-gear w-5"></i>إدارة المستخدمين
                </a>
            @endif
        </nav>

        <div class="mt-8 pt-6 border-t border-white/5">
            <a href="{{ route('home') }}" class="side-link"><i class="fa-solid fa-arrow-left w-5"></i>العودة للموقع</a>
            <form action="{{ route('auth.logout') }}" method="POST">@csrf
                <button type="submit" class="side-link w-full text-red-300 hover:text-red-200 hover:bg-red-500/10">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== المحتوى ===== --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-16 border-b border-cyan-400/10 flex items-center justify-between px-6 bg-[#05050a]/80">
            <h1 class="text-lg font-bold">@yield('title', 'لوحة التحكم')</h1>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-400">مرحباً،</span>
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold"
                     style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">
                    {{ mb_substr(auth()->user()->full_name, 0, 1) }}
                </div>
                <span class="text-sm font-semibold">
                    {{ auth()->user()->full_name }}
                    @if (auth()->user()->isSuperAdmin())
                        <span class="text-xs text-amber-300 mr-1">👑</span>
                    @endif
                </span>
            </div>
        </header>

        <main class="flex-1 p-6 overflow-x-auto">
            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg border border-green-400/30 bg-green-400/10 text-green-300 text-sm">
                    <i class="fa-solid fa-circle-check ml-2"></i>{{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
