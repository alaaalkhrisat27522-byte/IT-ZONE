<?php

namespace App\Services;

use App\Models\AcademicPlan;
use App\Models\CurriculumCourse;
use App\Models\GlossaryTerm;
use App\Models\Tutorial;
use Illuminate\Support\Facades\Http;

class AiAssistantService
{
    /** حالة المساعد — هل يوجد مفتاح؟ */
    public function status(): array
    {
        return [
            'configured' => filled(config('services.gemini.key')),
            'model' => config('services.gemini.model'),
        ];
    }

    /** المحادثة */
    public function chat(string $message, array $history = []): array
    {
        $key = config('services.gemini.key');

        if (blank($key)) {
            return $this->reply(
                '⚠️ المساعد غير مهيأ بعد! أضف GEMINI_API_KEY بملف .env — مفتاح مجاني من: https://aistudio.google.com/apikey',
                'setup-required'
            );
        }

        try {
            $response = Http::withHeaders(['x-goog-api-key' => $key])
                ->timeout(((int) env('AI_TIMEOUT_MS', 30000)) / 1000)                ->post('https://generativelanguage.googleapis.com/v1beta/models/' . config('services.gemini.model') . ':generateContent', [
                    'systemInstruction' => [
                        'parts' => [['text' => $this->systemPrompt()]],
                    ],
                    'contents' => array_merge($history, [
                        ['role' => 'user', 'parts' => [['text' => $message]]],
                    ]),
                    'generationConfig' => [
                        'temperature' => (float) env('AI_TEMPERATURE', 0.4),
                        'maxOutputTokens' => (int) env('AI_MAX_TOKENS', 2048),
                    ],
                    'safetySettings' => [
                        ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_NONE'],
                        ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_NONE'],
                        ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_NONE'],
                        ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_NONE'],
                    ],
                ]);

                if ($response->failed()) {
                $detail = data_get($response->json(), 'error.message', 'رمز الحالة: ' . $response->status());
                return $this->reply('⚠️ رد Google: ' . $detail, 'error', true);
            }

            $data = $response->json();
            $text = data_get($data, 'candidates.0.content.parts.0.text');

            if (blank($text)) {
                return $this->reply('⚠️ لم يصل رد من المساعد — جرّب إعادة صياغة سؤالك.', 'error', true);
            }

            return [
                'reply' => $text,
                'provider' => 'gemini',
                'model' => config('services.gemini.model'),
                'used_context' => true,
                'degraded' => false,
            ];
        } catch (\Throwable $e) {
            return $this->reply('⚠️ حدث خطأ غير متوقع بالمساعد.', 'error', true);
        }
    }

    /** التعليمات السرية + بيانات الموقع الحقيقية */
    private function systemPrompt(): string
    {
        $plans = AcademicPlan::withCount('courses')->get()
            ->map(fn ($p) => ['title' => $p->title, 'major' => $p->major, 'courses' => $p->courses_count, 'hours' => $p->total_hours]);

        $courses = CurriculumCourse::orderBy('code')->take(30)
            ->get(['name', 'code', 'hours', 'prerequisite_code', 'category']);

        $tutorials = Tutorial::published()->latest()->take(5)->get(['title', 'course_name', 'type']);
        $terms = GlossaryTerm::orderBy('term')->take(10)->get(['term', 'short_definition']);

        $context = json_encode([
            'academic_plans' => $plans,
            'sample_courses' => $courses,
            'tutorials' => $tutorials,
            'glossary' => $terms,
        ], JSON_UNESCAPED_UNICODE);

        return "أنت مساعد IT Zone الذكي 🎓 — المساعد الأكاديمي لطلاب كلية العلوم وتقنية المعلومات بجامعة الزرقاء.\n"
            . "أجب بالعربية المبسطة والودودة مع إيموجي مناسب، بإيجاز (فقرة قصيرة أو نقاط).\n"
            . "ساعد الطلاب بالتسجيل، المواد والمتطلبات، الشروحات، الأدوات، واقتراح مشاريع.\n"
            . "إذا السؤال خارج نطاق الدراسة والمنصة، أجب باختصار ووجّه الطالب للدراسة.\n\n"
            . "[IT_ZONE_ACADEMIC_CONTEXT]\n" . $context;
    }

    private function reply(string $text, string $provider, bool $degraded = false): array
    {
        return [
            'reply' => $text,
            'provider' => $provider,
            'model' => config('services.gemini.model'),
            'used_context' => false,
            'degraded' => $degraded,
        ];
    }
}
