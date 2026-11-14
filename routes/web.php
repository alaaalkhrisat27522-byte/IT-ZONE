<?php

use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
})->name('home');

// تسجيل الدخول والخروج
Route::get('/auth/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('auth.login');
Route::post('/auth/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/auth/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');

// ===== الأقسام العامة =====
Route::get('/roadmaps', [\App\Http\Controllers\RoadmapController::class, 'index'])->name('roadmaps.index');
Route::get('/roadmaps/{plan_ref}', [\App\Http\Controllers\RoadmapController::class, 'show'])->name('roadmaps.show');
Route::get('/tutorials', [\App\Http\Controllers\TutorialsController::class, 'index'])->name('tutorials.index');
Route::get('/glossary', [\App\Http\Controllers\GlossaryController::class, 'index'])->name('glossary.index');
Route::get('/tools', [\App\Http\Controllers\ToolsController::class, 'index'])->name('tools.index');
Route::get('/achievements', [\App\Http\Controllers\AchievementsController::class, 'index'])->name('achievements.index');


// التسجيل
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showForm'])->name('auth.register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

// المساعد الذكي (API)
Route::post('/api/ai-assistant/chat', [\App\Http\Controllers\AiAssistantController::class, 'chat'])->middleware('throttle:15,1');
Route::get('/api/ai-assistant/status', [\App\Http\Controllers\AiAssistantController::class, 'status']);
// غرف الدراسة
Route::get('/study-rooms', [\App\Http\Controllers\StudyRoomController::class, 'index'])->name('study-rooms.index');
Route::get('/study-rooms/{studyRoom}', [\App\Http\Controllers\StudyRoomController::class, 'show'])->name('study-rooms.show');
Route::middleware('admin')->group(function () {
    Route::post('/study-rooms', [\App\Http\Controllers\StudyRoomController::class, 'store'])->name('study-rooms.store');
    Route::delete('/study-rooms/{studyRoom}', [\App\Http\Controllers\StudyRoomController::class, 'destroy'])->name('study-rooms.destroy');
});

// ===== لوحة التحكم (للمدير فقط) =====
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // الشروحات
    Route::get('/tutorials', [\App\Http\Controllers\Admin\TutorialController::class, 'index'])->name('tutorials.index');
    Route::get('/tutorials/create', [\App\Http\Controllers\Admin\TutorialController::class, 'create'])->name('tutorials.create');
    Route::post('/tutorials', [\App\Http\Controllers\Admin\TutorialController::class, 'store'])->name('tutorials.store');
    Route::get('/tutorials/{tutorial}/edit', [\App\Http\Controllers\Admin\TutorialController::class, 'edit'])->name('tutorials.edit');
    Route::put('/tutorials/{tutorial}', [\App\Http\Controllers\Admin\TutorialController::class, 'update'])->name('tutorials.update');
    Route::patch('/tutorials/{tutorial}/toggle', [\App\Http\Controllers\Admin\TutorialController::class, 'toggle'])->name('tutorials.toggle');
    Route::delete('/tutorials/{tutorial}', [\App\Http\Controllers\Admin\TutorialController::class, 'destroy'])->name('tutorials.destroy');

    // القاموس
    Route::get('/glossary', [\App\Http\Controllers\Admin\GlossaryController::class, 'index'])->name('glossary.index');
    Route::get('/glossary/create', [\App\Http\Controllers\Admin\GlossaryController::class, 'create'])->name('glossary.create');
    Route::post('/glossary', [\App\Http\Controllers\Admin\GlossaryController::class, 'store'])->name('glossary.store');
    Route::get('/glossary/{term}/edit', [\App\Http\Controllers\Admin\GlossaryController::class, 'edit'])->name('glossary.edit');
    Route::put('/glossary/{term}', [\App\Http\Controllers\Admin\GlossaryController::class, 'update'])->name('glossary.update');
    Route::delete('/glossary/{term}', [\App\Http\Controllers\Admin\GlossaryController::class, 'destroy'])->name('glossary.destroy');

    // الأدوات
    Route::get('/tools', [\App\Http\Controllers\Admin\ToolController::class, 'index'])->name('tools.index');
    Route::get('/tools/create', [\App\Http\Controllers\Admin\ToolController::class, 'create'])->name('tools.create');
    Route::post('/tools', [\App\Http\Controllers\Admin\ToolController::class, 'store'])->name('tools.store');
    Route::get('/tools/{tool}/edit', [\App\Http\Controllers\Admin\ToolController::class, 'edit'])->name('tools.edit');
    Route::put('/tools/{tool}', [\App\Http\Controllers\Admin\ToolController::class, 'update'])->name('tools.update');
    Route::delete('/tools/{tool}', [\App\Http\Controllers\Admin\ToolController::class, 'destroy'])->name('tools.destroy');

    // الإنجازات
    Route::get('/achievements', [\App\Http\Controllers\Admin\AchievementController::class, 'index'])->name('achievements.index');
    Route::get('/achievements/create', [\App\Http\Controllers\Admin\AchievementController::class, 'create'])->name('achievements.create');
    Route::post('/achievements', [\App\Http\Controllers\Admin\AchievementController::class, 'store'])->name('achievements.store');
    Route::get('/achievements/{achievement}/edit', [\App\Http\Controllers\Admin\AchievementController::class, 'edit'])->name('achievements.edit');
    Route::put('/achievements/{achievement}', [\App\Http\Controllers\Admin\AchievementController::class, 'update'])->name('achievements.update');
    Route::patch('/achievements/{achievement}/toggle', [\App\Http\Controllers\Admin\AchievementController::class, 'toggle'])->name('achievements.toggle');
    Route::delete('/achievements/{achievement}', [\App\Http\Controllers\Admin\AchievementController::class, 'destroy'])->name('achievements.destroy');

    // المواد الدراسية
    Route::get('/courses', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [\App\Http\Controllers\Admin\CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [\App\Http\Controllers\Admin\CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [\App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('courses.destroy');

    // التصنيفات (شروحات / أدوات / إنجازات)
    Route::get('/categories/{type}', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->whereIn('type', ['tutorials', 'tools', 'achievements'])->name('categories.index');
    Route::get('/categories/{type}/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->whereIn('type', ['tutorials', 'tools', 'achievements'])->name('categories.create');
    Route::post('/categories/{type}', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->whereIn('type', ['tutorials', 'tools', 'achievements'])->name('categories.store');
    Route::get('/categories/{type}/{id}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->whereIn('type', ['tutorials', 'tools', 'achievements'])->name('categories.edit');
    Route::put('/categories/{type}/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->whereIn('type', ['tutorials', 'tools', 'achievements'])->name('categories.update');
    Route::delete('/categories/{type}/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->whereIn('type', ['tutorials', 'tools', 'achievements'])->name('categories.destroy');

    // إدارة المستخدمين (Super Admin فقط 👑)
    Route::middleware('super')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/promote', [\App\Http\Controllers\Admin\UserController::class, 'promote'])->name('users.promote');
        Route::patch('/users/{user}/demote', [\App\Http\Controllers\Admin\UserController::class, 'demote'])->name('users.demote');
        Route::patch('/users/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('users.toggle');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    });
});
Route::get('/setup-itzone-2026', function () {
    try {
        if (\App\Models\User::count() > 0) {
            return 'Already installed ✅';
        }
    } catch (\Throwable $e) {
    }
    \Artisan::call('migrate', ['--seed' => true, '--force' => true]);
    try {
        \Artisan::call('storage:link');
    } catch (\Throwable $e) {
    }
    return 'DONE ✅' . \Artisan::output();
});
