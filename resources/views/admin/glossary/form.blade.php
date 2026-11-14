@extends('layouts.admin')

@section('title', $term ? 'تعديل مصطلح' : 'إضافة مصطلح')

@section('content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-white mb-6">{{ $term ? '✏️ تعديل: ' . $term->term : '➕ إضافة مصطلح جديد' }}</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $term ? route('admin.glossary.update', $term) : route('admin.glossary.store') }}"
          class="neon-card p-8 space-y-5">
        @csrf
        @if ($term) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">المصطلح (بالإنجليزي) *</label>
                <input type="text" name="term" value="{{ old('term', $term->term ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">المعرف (slug) *</label>
                <input type="text" name="slug" value="{{ old('slug', $term->slug ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr" required>
            </div>
        </div>

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">التعريف المختصر *</label>
            <textarea name="short_definition" rows="2" class="neon-input w-full px-4 py-3" required>{{ old('short_definition', $term->short_definition ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">التعريف المفصل</label>
            <textarea name="detailed_definition" rows="4" class="neon-input w-full px-4 py-3">{{ old('detailed_definition', $term->detailed_definition ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التخصص</label>
                <input type="text" name="major" value="{{ old('major', $term->major ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">الصعوبة *</label>
                <select name="difficulty" class="neon-input w-full px-4 py-3" required>
                    @foreach (['مبتدئ', 'متوسط', 'متقدم'] as $level)
                        <option value="{{ $level }}" {{ old('difficulty', $term->difficulty ?? 'مبتدئ') === $level ? 'selected' : '' }}>{{ $level }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">التخصصات المرتبة (مفصولة بفواصل)</label>
            <input type="text" name="related_majors"
                   value="{{ old('related_majors', is_array($term->related_majors ?? null) ? implode(', ', $term->related_majors) : '') }}"
                   class="neon-input w-full px-4 py-3" placeholder="هندسة الحاسوب, هندسة البرمجيات">
        </div>

        <div>
            <label class="block text-sm text-[#94a3b8] mb-2">مثال</label>
            <textarea name="example" rows="2" class="neon-input w-full px-4 py-3">{{ old('example', $term->example ?? '') }}</textarea>
        </div>

        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 accent-cyan-400"
                   {{ old('is_featured', $term->is_featured ?? false) ? 'checked' : '' }}>
            <span class="text-sm">مميز (يظهر بالمقدمة)</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button class="neon-btn px-8 py-3 font-bold">
                <i class="fa-solid fa-floppy-disk ml-2"></i>{{ $term ? 'حفظ التعديلات' : 'إضافة المصطلح' }}
            </button>
            <a href="{{ route('admin.glossary.index') }}" class="px-8 py-3 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
