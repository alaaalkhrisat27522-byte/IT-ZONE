@extends('layouts.admin')

@section('title', 'إدارة المواد الدراسية')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-white">🎓 المواد الدراسية ({{ $courses->count() }})</h2>
    <a href="{{ route('admin.courses.create') }}" class="neon-btn px-5 py-2.5 font-bold">
        <i class="fa-solid fa-plus ml-2"></i>إضافة مادة
    </a>
</div>

<form method="GET" action="{{ route('admin.courses.index') }}" class="max-w-md mb-6">
    <div class="flex gap-3">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="🔍 اسم المادة أو رمزها..." class="neon-input flex-1 px-4 py-2.5">
        <button class="neon-btn px-5 py-2.5">بحث</button>
    </div>
</form>

<div class="neon-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/10 text-[#94a3b8]">
                <th class="p-4 text-right">الرمز</th>
                <th class="p-4 text-right">الاسم</th>
                <th class="p-4 text-right">الساعات</th>
                <th class="p-4 text-right">المتطلب</th>
                <th class="p-4 text-right">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                    <td class="p-4 font-mono text-cyan-300" dir="ltr">{{ $course->code }}</td>
                    <td class="p-4">
                        <div class="font-semibold text-white">{{ $course->name }}</div>
                        <div class="text-xs text-[#94a3b8]">{{ ['university' => 'جامعة', 'faculty' => 'كلية', 'college' => 'إجباري', 'major' => 'تخصص', 'elective' => 'اختياري'][$course->category] ?? $course->category }} — {{ $course->major ?? '' }}</div>
                    </td>
                    <td class="p-4 text-[#94a3b8]">{{ $course->hours }}</td>
                    <td class="p-4 text-purple-300 font-mono text-xs" dir="ltr">{{ $course->prerequisite_code ?? '—' }}</td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="neon-btn px-3 py-1.5 text-xs"><i class="fa-solid fa-pen"></i> تعديل</a>
                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('هل أنت متأكد من الحذف النهائي؟')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 text-xs rounded-lg border border-red-500/40 text-red-300 hover:bg-red-500/10"><i class="fa-solid fa-trash"></i> حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-10 text-center text-[#94a3b8]">لا توجد مواد.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
