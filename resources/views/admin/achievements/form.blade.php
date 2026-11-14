@extends('layouts.admin')

@section('title', $achievement ? 'تعديل إنجاز' : 'إضافة إنجاز')

@section('content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-white mb-6">{{ $achievement ? '✏️ تعديل: ' . $achievement->title : '➕ إضافة إنجاز جديد' }}</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm">
            <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $achievement ? route('admin.achievements.update', $achievement) : route('admin.achievements.store') }}"
          enctype="multipart/form-data" class="neon-card p-8 space-y-5">
        @csrf
        @if ($achievement) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">العنوان *</label>
                <input type="text" name="title" value="{{ old('title', $achievement->title ?? '') }}" class="neon-input w-full px-4 py-3" required>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">المعرف (slug) *</label>
                <input type="text" name="slug" value="{{ old('slug', $achievement->slug ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التصنيف</label>
                <select name="category_id" class="neon-input w-full px-4 py-3">
                    <option value="">— بدون —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $achievement->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">السنة</label>
                <input type="text" name="year" value="{{ old('year', $achievement->year ?? '') }}" class="neon-input w-full px-4 py-3" placeholder="2025">
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التخصص</label>
                <input type="text" name="major" value="{{ old('major', $achievement->major ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">أسماء الفريق</label>
                <input type="text" name="student_names" value="{{ old('student_names', $achievement->student_names ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">رابط المشروع</label>
                <input type="url" name="project_url" value="{{ old('project_url', $achievement->project_url ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">صورة المشروع</label>
                <input type="file" name="project_image" accept=".jpg,.jpeg,.png,.webp" class="neon-input w-full px-4 py-2.5">
                @if ($achievement && $achievement->project_image)
                    <img src="{{ asset('storage/' . $achievement->project_image) }}" class="mt-2 h-16 rounded-lg">
                @endif
            </div>
        </div>

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">الوصف</label>
            <textarea name="description" rows="4" class="neon-input w-full px-4 py-3">{{ old('description', $achievement->description ?? '') }}</textarea>
        </div>

        <div class="flex gap-8">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 accent-cyan-400" {{ old('is_featured', $achievement->is_featured ?? false) ? 'checked' : '' }}>
                <span class="text-sm">مميز ⭐</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_visible" value="1" class="w-5 h-5 accent-cyan-400" {{ old('is_visible', $achievement->is_visible ?? true) ? 'checked' : '' }}>
                <span class="text-sm">ظاهر للطلاب</span>
            </label>
        </div>

        <div class="flex gap-3 pt-2">
            <button class="neon-btn px-8 py-3 font-bold"><i class="fa-solid fa-floppy-disk ml-2"></i>{{ $achievement ? 'حفظ التعديلات' : 'إضافة الإنجاز' }}</button>
            <a href="{{ route('admin.achievements.index') }}" class="px-8 py-3 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white">إلغاء</a>
        </div>
    </form>
</div>
@endsection
