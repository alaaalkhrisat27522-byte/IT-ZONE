@extends('layouts.admin')

@section('title', $course ? 'تعديل مادة' : 'إضافة مادة')

@section('content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-white mb-6">{{ $course ? '✏️ تعديل: ' . $course->name : '➕ إضافة مادة جديدة' }}</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg border border-red-500/40 bg-red-500/10 text-red-300 text-sm">
            <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $course ? route('admin.courses.update', $course) : route('admin.courses.store') }}" class="neon-card p-8 space-y-5">
        @csrf
        @if ($course) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">الخطة *</label>
                <select name="plan_id" class="neon-input w-full px-4 py-3" required>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('plan_id', $course->plan_id ?? '') == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">رمز المادة *</label>
                <input type="text" name="code" value="{{ old('code', $course->code ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr" placeholder="CSCI101" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm text-[#94a3b8] mb-2">اسم المادة *</label>
                <input type="text" name="name" value="{{ old('name', $course->name ?? '') }}" class="neon-input w-full px-4 py-3" required>
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">الساعات *</label>
                <input type="number" name="hours" value="{{ old('hours', $course->hours ?? 3) }}" min="1" max="10" class="neon-input w-full px-4 py-3" required>
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التصنيف *</label>
                <select name="category" class="neon-input w-full px-4 py-3" required>
                    @foreach (['university' => 'مواد الجامعة', 'faculty' => 'مواد الكلية', 'college' => 'إجبارية', 'major' => 'مواد التخصص', 'elective' => 'اختيارية'] as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $course->category ?? 'major') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">رمز المتطلب (مثل CSCI101)</label>
                <input type="text" name="prerequisite_code" value="{{ old('prerequisite_code', $course->prerequisite_code ?? '') }}" class="neon-input w-full px-4 py-3" dir="ltr">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">اسم المتطلب</label>
                <input type="text" name="prerequisite_name" value="{{ old('prerequisite_name', $course->prerequisite_name ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>

            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">ملاحظة المتطلب</label>
                <input type="text" name="prerequisite_note" value="{{ old('prerequisite_note', $course->prerequisite_note ?? '') }}" class="neon-input w-full px-4 py-3" placeholder="+ 100 ساعة">
            </div>
            <div>
                <label class="block text-sm text-[#94a3b8] mb-2">التخصص</label>
                <input type="text" name="major" value="{{ old('major', $course->major ?? '') }}" class="neon-input w-full px-4 py-3">
            </div>
        </div>

        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="is_required" value="1" class="w-5 h-5 accent-cyan-400" {{ old('is_required', $course->is_required ?? true) ? 'checked' : '' }}>
            <span class="text-sm">مادة إجبارية</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button class="neon-btn px-8 py-3 font-bold"><i class="fa-solid fa-floppy-disk ml-2"></i>{{ $course ? 'حفظ التعديلات' : 'إضافة المادة' }}</button>
            <a href="{{ route('admin.courses.index') }}" class="px-8 py-3 rounded-lg border border-white/10 text-[#94a3b8] hover:text-white">إلغاء</a>
        </div>
    </form>
</div>
@endsection
