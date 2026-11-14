@extends('layouts.admin')

@section('title', $tool ? 'تعديل أداة' : 'إضافة أداة')

@section('content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-white mb-6">{{ $tool ? '✏️ تعديل: ' . $tool->name : '➕ إضافة أداة جديدة' }}</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm">
            <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $tool ? route('admin.tools.update', $tool) : route('admin.tools.store') }}" class="neon-card p-8 space-y-5">
        @csrf
        @if ($tool) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">اسم الأداة *</label>
                <input type="text" name="name" value="{{ old('name', $tool->name ?? '') }}" class="neon-input w-full px-4 py-3" required>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">المعرف (slug) *</label>
                <input type="text" name="slug" value="{{ old('slug', $tool->slug ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التصنيف</label>
                <select name="category_id" class="neon-input w-full px-4 py-3">
                    <option value="">— بدون —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $tool->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">الأيقونة (مثل: fa-code)</label>
                <input type="text" name="icon" value="{{ old('icon', $tool->icon ?? 'fa-wrench') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm text-[#94a3b8] mb-2">رابط الأداة</label>
                <input type="url" name="url" value="{{ old('url', $tool->url ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>
        </div>

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">الوصف</label>
            <textarea name="description" rows="3" class="neon-input w-full px-4 py-3">{{ old('description', $tool->description ?? '') }}</textarea>
        </div>

        <div class="flex gap-8">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_free" value="1" class="w-5 h-5 accent-cyan-400" {{ old('is_free', $tool->is_free ?? true) ? 'checked' : '' }}>
                <span class="text-sm">مجاني</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_approved" value="1" class="w-5 h-5 accent-cyan-400" {{ old('is_approved', $tool->is_approved ?? true) ? 'checked' : '' }}>
                <span class="text-sm">معتمدة (ظاهرة للطلاب)</span>
            </label>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="neon-btn px-8 py-3 font-bold"><i class="fa-solid fa-floppy-disk ml-2"></i>{{ $tool ? 'حفظ التعديلات' : 'إضافة الأداة' }}</button>
            <a href="{{ route('admin.tools.index') }}" class="px-8 py-3 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white">إلغاء</a>
        </div>
    </form>
</div>
@endsection
