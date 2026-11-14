@extends('layouts.admin')

@section('title', 'إدارة الإنجازات')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-white">🏆 الإنجازات ({{ $achievements->count() }})</h2>
    <a href="{{ route('admin.achievements.create') }}" class="neon-btn px-5 py-2.5 font-bold">
        <i class="fa-solid fa-plus ml-2"></i>إضافة إنجاز
    </a>
</div>

<div class="neon-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/10 text-[#94a3b8]">
                <th class="p-4 text-right">العنوان</th>
                <th class="p-4 text-right">الفريق</th>
                <th class="p-4 text-right">السنة</th>
                <th class="p-4 text-right">الظهور</th>
                <th class="p-4 text-right">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($achievements as $achievement)
                <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                    <td class="p-4">
                        <div class="font-semibold text-white">{{ $achievement->title }}</div>
                        <div class="text-xs text-[#94a3b8]">{{ $achievement->category->name ?? '—' }}</div>
                    </td>
                    <td class="p-4 text-[#94a3b8]">{{ $achievement->student_names ?? '—' }}</td>
                    <td class="p-4 text-[#94a3b8]">{{ $achievement->year ?? '—' }}</td>
                    <td class="p-4">
                        <form method="POST" action="{{ route('admin.achievements.toggle', $achievement) }}">
                            @csrf @method('PATCH')
                            <button class="text-xs px-3 py-1.5 rounded-full {{ $achievement->is_visible ? 'bg-green-400/10 text-green-300' : 'bg-white/5 text-[#94a3b8]' }}">
                                {{ $achievement->is_visible ? '● ظاهر' : '○ مخفي' }}
                            </button>
                        </form>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.achievements.edit', $achievement) }}" class="neon-btn px-3 py-1.5 text-xs"><i class="fa-solid fa-pen"></i> تعديل</a>
                            <form method="POST" action="{{ route('admin.achievements.destroy', $achievement) }}" onsubmit="return confirm('هل أنت متأكد من الحذف النهائي؟')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 text-xs rounded-lg border border-red-500/40 text-red-300 hover:bg-red-500/10"><i class="fa-solid fa-trash"></i> حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-10 text-center text-[#94a3b8]">لا توجد إنجازات.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
