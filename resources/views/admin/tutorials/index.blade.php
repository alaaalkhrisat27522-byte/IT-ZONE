@extends('layouts.admin')

@section('title', 'إدارة الشروحات')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-white">📚 الشروحات ({{ $tutorials->count() }})</h2>
    <a href="{{ route('admin.tutorials.create') }}" class="neon-btn px-5 py-2.5 font-bold">
        <i class="fa-solid fa-plus ml-2"></i>إضافة شرح جديد
    </a>
</div>

<div class="neon-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/10 text-[#94a3b8]">
                <th class="p-4 text-right">العنوان</th>
                <th class="p-4 text-right">النوع</th>
                <th class="p-4 text-right">التصنيف</th>
                <th class="p-4 text-right">الحالة</th>
                <th class="p-4 text-right">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tutorials as $tutorial)
                <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                    <td class="p-4">
                        <div class="font-semibold text-white">{{ $tutorial->title }}</div>
                        <div class="text-xs text-[#94a3b8]" dir="ltr">{{ $tutorial->slug }}</div>
                    </td>
                    <td class="p-4">
                        {{ ['summary' => '📄 ملخص', 'mindmap' => '🗺️ خريطة', 'video' => '🎬 فيديو'][$tutorial->type] ?? $tutorial->type }}
                    </td>
                    <td class="p-4 text-[#94a3b8]">{{ $tutorial->category->name ?? '—' }}</td>
                    <td class="p-4">
                        <form method="POST" action="{{ route('admin.tutorials.toggle', $tutorial) }}">
                            @csrf @method('PATCH')
                            <button class="text-xs px-3 py-1.5 rounded-full {{ $tutorial->is_published ? 'bg-green-400/10 text-green-300' : 'bg-white/5 text-[#94a3b8]' }}">
                                {{ $tutorial->is_published ? '● منشور' : '○ مخفي' }}
                            </button>
                        </form>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.tutorials.edit', $tutorial) }}" class="neon-btn px-3 py-1.5 text-xs">
                                <i class="fa-solid fa-pen"></i> تعديل
                            </a>
                            <form method="POST" action="{{ route('admin.tutorials.destroy', $tutorial) }}"
                                  onsubmit="return confirm('هل أنت متأكد من الحذف النهائي؟')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 text-xs rounded-lg border border-red-500/40 text-red-300 hover:bg-red-500/10">
                                    <i class="fa-solid fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-10 text-center text-[#94a3b8]">لا توجد شروحات — ابدأ بإضافة واحدة!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
