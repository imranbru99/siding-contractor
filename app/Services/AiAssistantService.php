<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class AiAssistantService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'how long does siding take timeline install',
            'a' => 'Most Northclad residential reclads run 5–12 working days after material delivery, depending on home size, tear-off complexity, and weather. Storm repairs can finish in 1–3 days; multifamily phases take longer.',
        ],
        [
            'q' => 'cost price estimate budget',
            'a' => 'Typical Twin Cities siding projects range from about $8–$18+ per square foot installed, depending on material (vinyl, fiber cement, wood, metal), tear-off, WRB, trim, and access. We provide a free on-site estimate.',
        ],
        [
            'q' => 'fiber cement hardie james hardie rainscreen',
            'a' => 'Fiber cement is our most requested premium system. Northclad installs with manufacturer-approved fasteners, continuous WRB, and optional rainscreen furring so the cladding can dry behind Minnesota wind-driven rain.',
        ],
        [
            'q' => 'vinyl insulated energy',
            'a' => 'Insulated vinyl adds a foam backer that improves comfort and curb appeal at a lower cost than fiber cement. We still detail openings and housewrap properly — insulation does not replace flashing.',
        ],
        [
            'q' => 'moisture wrap flashing window wrb ice dam',
            'a' => 'Moisture management is non-negotiable. We install continuous weather-resistive barrier, pan flashings at openings, kickouts at roof-to-wall, and taped seams so water cannot soak sheathing behind the new siding.',
        ],
        [
            'q' => 'hail storm damage insurance repair',
            'a' => 'After hail or wind events we document damage, match profiles and colors where possible, and coordinate with insurance adjusters. Repairs range from single elevations to full-home replacement when impact is widespread.',
        ],
        [
            'q' => 'wood cedar paint stain maintenance',
            'a' => 'Wood and engineered wood look exceptional but need finish cycles. We discuss stain vs paint systems, ventilated cavities, and realistic maintenance intervals for northern exposure before you commit.',
        ],
        [
            'q' => 'schedule appointment consult estimate',
            'a' => 'Book a free estimate via our contact form or WhatsApp. A Northclad lead will measure elevations, review moisture concerns, discuss material options, and send a scoped proposal within a few business days.',
        ],
        [
            'q' => 'hoa duplex multifamily commercial',
            'a' => 'We regularly clad duplexes, townhomes, and light commercial buildings with phased staging so tenants stay put. Aesthetic finishes can match HOA guidelines while meeting weather detailing standards.',
        ],
        [
            'q' => 'warranty guarantee',
            'a' => 'Northclad craftsmanship on siding installs is warrantied for 5 years against workmanship defects. Manufacturer warranties on cladding, WRB, and trim products are passed through to you.',
        ],
    ];

    public function chat(string $message, string $context = 'public'): string
    {
        $message = trim($message);
        if ($message === '') {
            return 'Ask anything about siding materials, moisture detailing, timelines, costs, or Northclad project workflow.';
        }

        if ($this->hasOpenAiKey()) {
            try {
                $reply = $this->openaiReply($message, $context);
                if ($reply !== null) {
                    return $reply;
                }
            } catch (Throwable) {
                // Fall through to Gemini, then FAQ.
            }
        }

        if ($this->hasGeminiKey()) {
            try {
                $reply = $this->geminiReply($message, $context);
                if ($reply !== null) {
                    return $reply;
                }
            } catch (Throwable) {
                // Fall through to FAQ demo mode.
            }
        }

        return $this->faqReply($message);
    }

    public function generateContent(string $type, string $topic): string
    {
        $prompt = match ($type) {
            'blog' => "Write a practical 400-word blog post outline and intro for Northclad Siding about: {$topic}",
            'service' => "Write a persuasive service description for a siding offering: {$topic}",
            'email' => "Write a short homeowner follow-up email about: {$topic}",
            default => "Write helpful siding contractor copy about: {$topic}",
        };

        return $this->chat($prompt, 'generator');
    }

    public function automationSuggestions(): string
    {
        return $this->chat(
            'Suggest 5 practical ERP automations for a US siding contractor using jobs, inventory, invoices, and appointments.',
            'automation'
        );
    }

    public function troubleshoot(string $issue): string
    {
        return $this->chat(
            "Troubleshoot this siding / admin workflow issue and give step-by-step checks: {$issue}",
            'troubleshoot'
        );
    }

    protected function faqReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $token) {
                if ($token !== '' && Str::contains($hay, $token)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best.' (Demo AI mode — add OPENAI_API_KEY or GEMINI_API_KEY for live model replies.)';
        }

        return 'Thanks for asking Northclad. We install fiber cement, vinyl, wood, and metal siding across Minneapolis–Saint Paul with moisture-first detailing, storm restoration, and clean trim work. Share wall square footage, material preference, and your suburb for a tighter estimate—or book a free estimate. (Demo AI mode.)';
    }

    protected function systemPrompt(string $context): string
    {
        $base = 'You are the AI assistant for Northclad Siding, a US siding contractor in Minneapolis, Minnesota (Twin Cities). Be concise, practical, and moisture/code-aware. Never invent legal or structural engineering advice; recommend local permits, manufacturer specs, and inspections when appropriate.';

        return match ($context) {
            'generator' => $base.' Generate clear marketing or operational copy for siding installation and repair.',
            'automation' => $base.' Focus on Filament ERP workflows: leads, projects, inventory, invoices, scheduling.',
            'troubleshoot' => $base.' Help staff diagnose moisture, cladding failure, scheduling, invoice, or CRM issues step by step.',
            default => $base.' Answer homeowner FAQs about siding materials, moisture, cost ranges, and next steps.',
        };
    }

    protected function hasOpenAiKey(): bool
    {
        return filled(config('services.ai.openai_key'));
    }

    protected function hasGeminiKey(): bool
    {
        return filled(config('services.ai.gemini_key'));
    }

    protected function openaiReply(string $message, string $context): ?string
    {
        $response = Http::withToken(config('services.ai.openai_key'))
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.ai.openai_model', 'gpt-4o-mini'),
                'messages' => [
                    ['role' => 'system', 'content' => $this->systemPrompt($context)],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        if (! $response->successful()) {
            return null;
        }

        $text = data_get($response->json(), 'choices.0.message.content');

        return filled($text) ? trim((string) $text) : null;
    }

    protected function geminiReply(string $message, string $context): ?string
    {
        $key = config('services.ai.gemini_key');
        $model = config('services.ai.gemini_model', 'gemini-1.5-flash');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}";

        $response = Http::timeout(20)->post($url, [
            'contents' => [[
                'parts' => [[
                    'text' => $this->systemPrompt($context)."\n\nUser: {$message}",
                ]],
            ]],
        ]);

        if (! $response->successful()) {
            return null;
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

        return filled($text) ? trim((string) $text) : null;
    }
}
