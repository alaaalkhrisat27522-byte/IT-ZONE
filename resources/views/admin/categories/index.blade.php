@extends('layouts.admin')

@section('title', 'إدارة التصنيفات')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-white">🏷️ {{ $config['label'] }}</h2>
    <a href="{{ route('admin.categories.create', $type) }}" class="neon-btn px-5 py-2.5 font-bold">
        <i class="fa-solid fa-plus ml-2"></i>إضافة تصنيف
    </a>
</div>

<!-- تبويبات الأنواع -->
<div class="flex gap-2 mb-6">
    @foreach (['tutorials' => 'الشروحات', 'tools' => 'الأدوات', 'achievements' => 'الإنجازات'] as $key => $label)
        <a href="{{ route('admin.categories.index', $key) }}"
           class="px-5 py-2.5 rounded-lg text-sm transition {{ $type === $key ? 'neon-btn font-bold' : 'border border-white/10 text-[#94a3b8] hover:text-white' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="neon-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/10 text-[#94a3b8]">
                <th class="p-4 text-right">الاسم</th>
                <th class="p-4 text-right">اللون</th>
                <th class="p-4 text-right">الترتيب</th>
                <th class="p-4 text-right">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr class="border-b border-white/5 hover:bg-white/[0.03]">
                    <td class="p-4">
                        <div class="font-semibold text-white"><i class="fa-solid {{ $category->icon ?? 'fa-tag' }} ml-2"></i>{{ $category->name }}</div>
                        <div class="text-xs text-[#94a3b8]">{{ $category->description ?? '' }}</div>
                    </td>
                    <td class="p-4">
                        <span class="inline-block w-6 h-6 rounded-lg" style="background: {{ $category->color ?? '#00d4ff' }};"></span>
                    </td>
                    <td class="p-4 text-[#94a3b8]">{{ $category->sort_order }}</td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.categories.edit', [$type, $category->id]) }}" class="neon-btn px-3 py-1.5 text-xs"><i class="fa-solid fa-pen"></i> تعديل</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', [$type, $category->id]) }}" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 text-xs rounded-lg border border-red-500/40 text-red-300 hover:bg-red-500/10"><i class="fa-solid fa-trash"></i> حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-10 text-center text-[#94a3b8]">لا توجد تصنيفات.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
