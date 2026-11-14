@extends('layouts.admin')

@section('title', $tutorial ? 'تعديل شرح' : 'إضافة شرح جديد')

@section('content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-white mb-6">{{ $tutorial ? '✏️ تعديل: ' . $tutorial->title : '➕ إضافة شرح جديد' }}</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $tutorial ? route('admin.tutorials.update', $tutorial) : route('admin.tutorials.store') }}"
          enctype="multipart/form-data" class="neon-card p-8 space-y-5">
        @csrf
        @if ($tutorial) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">العنوان *</label>
                <input type="text" name="title" value="{{ old('title', $tutorial->title ?? '') }}" class="neon-input w-full px-4 py-3" required>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">المعرف بالإنجليزي (slug) *</label>
                <input type="text" name="slug" value="{{ old('slug', $tutorial->slug ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">النوع *</label>
                <select name="type" class="neon-input w-full px-4 py-3" required>
                    <option value="summary" {{ old('type', $tutorial->type ?? '') === 'summary' ? 'selected' : '' }}>📄 ملخص</option>
                    <option value="mindmap" {{ old('type', $tutorial->type ?? '') === 'mindmap' ? 'selected' : '' }}>🗺️ خريطة ذهنية</option>
                    <option value="video" {{ old('type', $tutorial->type ?? '') === 'video' ? 'selected' : '' }}>🎬 فيديو</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التصنيف</label>
                <select name="category_id" class="neon-input w-full px-4 py-3">
                    <option value="">— بدون —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $tutorial->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">اسم المادة</label>
                <input type="text" name="course_name" value="{{ old('course_name', $tutorial->course_name ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التخصص</label>
                <input type="text" name="major" value="{{ old('major', $tutorial->major ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">رابط فيديو يوتيوب</label>
                <input type="url" name="video_url" value="{{ old('video_url', $tutorial->video_url ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">رابط الكود المصدري</label>
                <input type="url" name="source_code_url" value="{{ old('source_code_url', $tutorial->source_code_url ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>
        </div>

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">الوصف المختصر</label>
            <textarea name="excerpt" rows="3" class="neon-input w-full px-4 py-3">{{ old('excerpt', $tutorial->excerpt ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">المرفقات (PDF أو صورة — حتى 10 ميغا)</label>
                <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.webp,.gif" class="neon-input w-full px-4 py-2.5">
                @if ($tutorial && $tutorial->file_path)
                    <div class="text-xs text-[#94a3b8] mt-2"><i class="fa-solid fa-paperclip ml-1"></i>يوجد ملف مرفق حالياً (رفع ملف جديد يستبدله)</div>
                @endif
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">الكاتب</label>
                <input type="text" name="author" value="{{ old('author', $tutorial->author ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>
        </div>

        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_published" value="1" class="w-5 h-5 accent-cyan-400"
                   {{ old('is_published', $tutorial->is_published ?? true) ? 'checked' : '' }}>
            <span class="text-sm">منشور (ظاهر للطلاب)</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button class="neon-btn px-8 py-3 font-bold">
                <i class="fa-solid fa-floppy-disk ml-2"></i>{{ $tutorial ? 'حفظ التعديلات' : 'إضافة الشرح' }}
            </button>
            <a href="{{ route('admin.tutorials.index') }}" class="px-8 py-3 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
