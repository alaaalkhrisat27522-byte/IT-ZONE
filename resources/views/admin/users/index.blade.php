@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-white">👥 المستخدمون ({{ $users->count() }})</h2>
</div>

<form method="GET" action="{{ route('admin.users.index') }}" class="max-w-md mb-6">
    <div class="flex gap-3">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="🔍 ابحث بالاسم أو الإيميل..." class="neon-input flex-1 px-4 py-2.5">
        <button class="neon-btn px-5 py-2.5">بحث</button>
    </div>
</form>

<div class="neon-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/10 text-[#94a3b8]">
                <th class="p-4 text-right">المستخدم</th>
                <th class="p-4 text-right">الدور</th>
                <th class="p-4 text-right">الحالة</th>
                <th class="p-4 text-right">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold"
                                 style="background: linear-gradient(135deg, #00d4ff, #bc13fe); color: #05050a;">
                                {{ mb_substr($user->full_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold text-white">{{ $user->full_name }}</div>
                                <div class="text-xs text-[#94a3b8]" dir="ltr">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="text-xs px-3 py-1 rounded-full {{ $user->role->slug === 'super_admin' ? 'bg-amber-400/10 text-amber-300' : ($user->role->slug === 'admin' ? 'bg-cyan-400/10 text-cyan-300' : 'bg-white/5 text-[#94a3b8]') }}">
                            {{ $user->role->slug === 'super_admin' ? '👑 Super Admin' : $user->role->name }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="text-xs px-3 py-1 rounded-full {{ $user->is_active ? 'bg-green-400/10 text-green-300' : 'bg-red-400/10 text-red-300' }}">
                            {{ $user->is_active ? '● نشط' : '🚫 محظور' }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if (! $user->isSuperAdmin())
                            <div class="flex flex-wrap gap-2">
                                @if ($user->role->slug === 'user')
                                    <form method="POST" action="{{ route('admin.users.promote', $user) }}">
                                        @csrf @method('PATCH')
                                        <button class="neon-btn px-3 py-1.5 text-xs"><i class="fa-solid fa-arrow-up"></i> ترقية لأدمن</button>
                                    </form>
                                @elseif ($user->role->slug === 'admin')
                                    <form method="POST" action="{{ route('admin.users.demote', $user) }}">
                                        @csrf @method('PATCH')
                                        <button class="px-3 py-1.5 text-xs rounded-lg border border-amber-500/40 text-amber-300 hover:bg-amber-500/10"><i class="fa-solid fa-arrow-down"></i> تنزيل لمستخدم</button>
                                    </form>
                                @endif

                                @if ($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                        @csrf @method('PATCH')
                                        <button class="px-3 py-1.5 text-xs rounded-lg border {{ $user->is_active ? 'border-red-500/40 text-red-300 hover:bg-red-500/10' : 'border-green-500/40 text-green-300 hover:bg-green-500/10' }}">
                                            <i class="fa-solid {{ $user->is_active ? 'fa-ban' : 'fa-check' }}"></i> {{ $user->is_active ? 'حظر' : 'تفعيل' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('⚠️ الحذف نهائي! متأكد؟')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1.5 text-xs rounded-lg border border-red-500/40 text-red-300 hover:bg-red-500/10"><i class="fa-solid fa-trash"></i> حذف</button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-amber-300">👑 لا يمكن تعديله</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-10 text-center text-[#94a3b8]">لا يوجد مستخدمون مطابقون.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
