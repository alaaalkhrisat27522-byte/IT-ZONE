@extends('layouts.admin')

@section('title', $category ? 'تعديل تصنيف' : 'إضافة تصنيف')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-white mb-6">{{ $category ? '✏️ تعديل: ' . $category->name : '➕ إضافة تصنيف جديد' }}</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm">
            <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $category ? route('admin.categories.edit', [$type, $category->id]) : route('admin.categories.create', $type) }}"
          class="neon-card p-8 space-y-5">
        @csrf
        @if ($category) @method('PUT') @endif

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">الاسم *</label>
            <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="neon-input w-full px-4 py-3" required>
        </div>

        @if ($config['has_slug'])
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">المعرف (slug) *</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>
        @endif

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">الوصف</label>
            <textarea name="description" rows="2" class="neon-input w-full px-4 py-3">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">اللون (مثل #00d4ff)</label>
                <input type="text" name="color" value="{{ old('color', $category->color ?? '#00d4ff') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">الأيقونة (مثل fa-tag)</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon ?? 'fa-tag') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">الترتيب</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="neon-input w-full px-4 py-3">
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="neon-btn px-8 py-3 font-bold"><i class="fa-solid fa-floppy-disk ml-2"></i>{{ $category ? 'حفظ التعديلات' : 'إضافة التصنيف' }}</button>
            <a href="{{ route('admin.categories.index', $type) }}" class="px-8 py-3 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white">إلغاء</a>
        </div>
    </form>
</div>
@endsection
