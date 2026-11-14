<?php

namespace Database\Seeders;

use App\Models\AcademicPlan;
use App\Models\Achievement;
use App\Models\AchievementCategory;
use App\Models\CurriculumCourse;
use App\Models\GlossaryTerm;
use App\Models\Tool;
use App\Models\ToolCategory;
use App\Models\Tutorial;
use App\Models\TutorialCategory;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // ===== الشروحات =====
        $summary = TutorialCategory::firstOrCreate(['slug' => 'summaries'], ['name' => '📚 ملخصات', 'color' => '#00d4ff', 'icon' => 'fa-file-lines', 'sort_order' => 1]);
        $maps = TutorialCategory::firstOrCreate(['slug' => 'mindmaps'], ['name' => '🗺️ خرائط ذهنية', 'color' => '#bc13fe', 'icon' => 'fa-diagram-project', 'sort_order' => 2]);

        Tutorial::firstOrCreate(['slug' => 'csci101-summary'], [
            'category_id' => $summary->id, 'title' => 'ملخص مقدمة في الحاسوب CSCI101', 'type' => 'summary',
            'course_name' => 'مقدمة في الحاسوب', 'major' => 'هندسة الحاسوب', 'author' => 'Alaa',
            'excerpt' => 'ملخص شامل لمادة مقدمة في الحاسوب — أهم المفاهيم والأسئلة المتوقعة.',
        ]);
        Tutorial::firstOrCreate(['slug' => 'csci201-mindmap'], [
            'category_id' => $maps->id, 'title' => 'خريطة ذهنية — هياكل البيانات CSCI201', 'type' => 'mindmap',
            'course_name' => 'هياكل البيانات', 'major' => 'هندسة الحاسوب', 'author' => 'Alaa',
            'excerpt' => 'خريطة ذهنية للمصفوفات والقوائم والأشجار والرسوم البيانية.',
        ]);

        // ===== القاموس =====
        foreach ([
            ['term' => 'Algorithm', 'slug' => 'algorithm', 'short_definition' => 'خطوات محددة لحل مشكلة أو إنجاز مهمة.', 'example' => 'خوارزمية البحث الثنائي تبحث في مصفوفة مرتبة بسرعة.', 'difficulty' => 'مبتدئ', 'is_featured' => true],
            ['term' => 'API', 'slug' => 'api', 'short_definition' => 'واجهة تسمح للبرامج بالتواصل مع بعضها البعض.', 'example' => 'المساعد الذكي يستخدم Gemini API.', 'difficulty' => 'متوسط', 'is_featured' => true],
            ['term' => 'Database', 'slug' => 'database', 'short_definition' => 'مكان منظم لتخزين البيانات واسترجاعها.', 'example' => 'MySQL و SQLite و MongoDB.', 'difficulty' => 'مبتدئ', 'is_featured' => true],
            ['term' => 'Framework', 'slug' => 'framework', 'short_definition' => 'هيكل جاهز يسرّع بناء البرمجيات.', 'example' => 'Laravel للـ PHP و React للواجهات.', 'difficulty' => 'مبتدئ', 'is_featured' => true],
            ['term' => 'Git', 'slug' => 'git', 'short_definition' => 'نظام لتتبع التغييرات في الكود والعمل الجماعي.', 'example' => 'git commit -m "add login page"', 'difficulty' => 'متوسط', 'is_featured' => true],
        ] as $t) {
            GlossaryTerm::firstOrCreate(['slug' => $t['slug']], $t);
        }

        // ===== الأدوات =====
        $devTools = ToolCategory::firstOrCreate(['slug' => 'dev-tools'], ['name' => '🖥️ أدوات تطوير', 'color' => '#00d4ff', 'icon' => 'fa-code', 'sort_order' => 1]);
        $studyTools = ToolCategory::firstOrCreate(['slug' => 'study-tools'], ['name' => '📖 أدوات دراسة', 'color' => '#bc13fe', 'icon' => 'fa-book', 'sort_order' => 2]);

        foreach ([
            ['category_id' => $devTools->id, 'name' => 'VS Code', 'slug' => 'vscode', 'description' => 'محرر الأكواد الأشهر — مجاني وخفيف.', 'url' => 'https://code.visualstudio.com', 'icon' => 'fa-code'],
            ['category_id' => $devTools->id, 'name' => 'Git', 'slug' => 'git', 'description' => 'نظام التحكم بالإصدارات.', 'url' => 'https://git-scm.com', 'icon' => 'fa-git-alt'],
            ['category_id' => $studyTools->id, 'name' => 'Excalidraw', 'slug' => 'excalidraw', 'description' => 'ارسم خرائط ذهنية ورسومات بسهولة.', 'url' => 'https://excalidraw.com', 'icon' => 'fa-pencil'],
            ['category_id' => $studyTools->id, 'name' => 'Pomofocus', 'slug' => 'pomofocus', 'description' => 'مؤقت بومودورو للدراسة.', 'url' => 'https://pomofocus.io', 'icon' => 'fa-clock'],
        ] as $tool) {
            Tool::firstOrCreate(['slug' => $tool['slug']], $tool);
        }

        // ===== الإنجازات =====
        $finalProjects = AchievementCategory::firstOrCreate(['name' => 'مشاريع التخرج'], ['color' => '#00d4ff', 'icon' => 'fa-trophy', 'sort_order' => 1]);

        Achievement::firstOrCreate(['slug' => 'rawasi'], [
            'title' => 'رواسي', 'category_id' => $finalProjects->id,
            'description' => 'منصة جامعية متكاملة لإدارة الخدمات الطلابية.',
            'student_names' => 'فريق رواسي', 'major' => 'هندسة الحاسوب', 'year' => '2025',
            'is_featured' => true,
        ]);
        Achievement::firstOrCreate(['slug' => 'wendy'], [
            'title' => 'WENDY', 'category_id' => $finalProjects->id,
            'description' => 'نظام ذكي لإدارة المهام والدراسة.',
            'student_names' => 'فريق WENDY', 'major' => 'هندسة البرمجيات', 'year' => '2025',
            'is_featured' => true,
        ]);

        // ===== شجرة التخصصات =====
        $plan = AcademicPlan::firstOrCreate(['plan_ref' => 'computer-engineering-2025-2026'], [
            'major' => 'هندسة الحاسوب', 'title' => 'خطة هندسة الحاسوب 2025/2026',
            'description' => 'الخطة الدراسية الكاملة — 160 ساعة، شجرة المتطلبات والمواد.',
            'total_hours' => 160, 'total_courses' => 42, 'source' => 'عمادة القبول والتسجيل',
        ]);

        foreach ([
            ['code' => 'CSCI101', 'name' => 'مقدمة في الحاسوب', 'hours' => 3, 'prerequisite_code' => null, 'category' => 'major', 'is_required' => true],
            ['code' => 'MATH101', 'name' => 'التفاضل والتكامل 1', 'hours' => 3, 'prerequisite_code' => null, 'category' => 'university', 'is_required' => true],
            ['code' => 'CSCI102', 'name' => 'البرمجة 1', 'hours' => 3, 'prerequisite_code' => 'CSCI101', 'prerequisite_name' => 'مقدمة في الحاسوب', 'category' => 'major', 'is_required' => true],
            ['code' => 'CSCI201', 'name' => 'هياكل البيانات', 'hours' => 3, 'prerequisite_code' => 'CSCI102', 'prerequisite_name' => 'البرمجة 1', 'category' => 'major', 'is_required' => true],
            ['code' => 'CSCI301', 'name' => 'قواعد البيانات', 'hours' => 3, 'prerequisite_code' => 'CSCI102', 'prerequisite_name' => 'البرمجة 1', 'category' => 'major', 'is_required' => true],
            ['code' => 'CSCI401', 'name' => 'مشروع التخرج', 'hours' => 3, 'prerequisite_code' => 'CSCI201', 'prerequisite_name' => 'هياكل البيانات', 'prerequisite_note' => '+ 100 ساعة', 'category' => 'major', 'is_required' => true],
        ] as $c) {
            CurriculumCourse::firstOrCreate(['code' => $c['code']], array_merge($c, [
                'plan_id' => $plan->id,
                'plan_ref' => $plan->plan_ref,
                'major' => 'هندسة الحاسوب',
            ]));
        }
    }
}
