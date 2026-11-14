@extends('layouts.admin')

@section('title', 'إدارة الأدوات')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-white">🧰 الأدوات ({{ $tools->count() }})</h2>
    <a href="{{ route('admin.tools.create') }}" class="neon-btn px-5 py-2.5 font-bold">
        <i class="fa-solid fa-plus ml-2"></i>إضافة أداة
    </a>
</div>

<div class="neon-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/10 text-[#94a3b8]">
                <th class="p-4 text-right">الاسم</th>
                <th class="p-4 text-right">التصنيف</th>
                <th class="p-4 text-right">التكلفة</th>
                <th class="p-4 text-right">الرابط</th>
                <th class="p-4 text-right">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tools as $tool)
                <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                    <td class="p-4">
                        <div class="font-semibold text-white"><i class="fa-solid {{ $tool->icon ?? 'fa-wrench' }} ml-2 neon-blue"></i>{{ $tool->name }}</div>
                        <div class="text-xs text-[#94a3b8]" dir="ltr">{{ $tool->slug }}</div>
                    </td>
                    <td class="p-4 text-[#94a3b8]">{{ $tool->category->name ?? '—' }}</td>
                    <td class="p-4">
                        <span class="text-xs px-2.5 py-1 rounded-full {{ $tool->is_free ? 'bg-green-400/10 text-green-300' : 'bg-amber-400/10 text-amber-300' }}">
                            {{ $tool->is_free ? 'مجاني' : 'مدفوع' }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if ($tool->url)
                            <a href="{{ $tool->url }}" target="_blank" class="text-cyan-300 hover:text-cyan-200 text-xs" dir="ltr">{{ \Illuminate\Support\Str::limit($tool->url, 30) }}</a>
                        @else — @endif
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.tools.edit', $tool) }}" class="neon-btn px-3 py-1.5 text-xs"><i class="fa-solid fa-pen"></i> تعديل</a>
                            <form method="POST" action="{{ route('admin.tools.destroy', $tool) }}" onsubmit="return confirm('هل أنت متأكد من الحذف النهائي؟')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 text-xs rounded-lg border border-red-500/40 text-red-300 hover:bg-red-500/10"><i class="fa-solid fa-trash"></i> حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-10 text-center text-[#94a3b8]">لا توجد أدوات.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
