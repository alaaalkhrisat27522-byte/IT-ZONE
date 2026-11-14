@extends('layouts.admin')

@section('title', 'إدارة القاموس')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-white">📚 مصطلحات القاموس ({{ $terms->count() }})</h2>
    <a href="{{ route('admin.glossary.create') }}" class="neon-btn px-5 py-2.5 font-bold">
        <i class="fa-solid fa-plus ml-2"></i>إضافة مصطلح
    </a>
</div>

<div class="neon-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/10 text-[#94a3b8]">
                <th class="p-4 text-right">المصطلح</th>
                <th class="p-4 text-right">التعريف المختصر</th>
                <th class="p-4 text-right">الصعوبة</th>
                <th class="p-4 text-right">مميز</th>
                <th class="p-4 text-right">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($terms as $term)
                <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                    <td class="p-4">
                        <div class="font-semibold neon-blue font-mono" dir="ltr">{{ $term->term }}</div>
                        <div class="text-xs text-[#94a3b8]" dir="ltr">{{ $term->slug }}</div>
                    </td>
                    <td class="p-4 text-[#94a3b8] max-w-xs">{{ \Illuminate\Support\Str::limit($term->short_definition, 60) }}</td>
                    <td class="p-4">{{ $term->difficulty }}</td>
                    <td class="p-4">{{ $term->is_featured ? '⭐' : '—' }}</td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.glossary.edit', $term) }}" class="neon-btn px-3 py-1.5 text-xs">
                                <i class="fa-solid fa-pen"></i> تعديل
                            </a>
                            <form method="POST" action="{{ route('admin.glossary.destroy', $term) }}"
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
                <tr><td colspan="5" class="p-10 text-center text-[#94a3b8]">لا توجد مصطلحات.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
