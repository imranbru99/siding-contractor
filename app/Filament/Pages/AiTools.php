<?php

namespace App\Filament\Pages;

use App\Services\AiAssistantService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AiTools extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'AI';

    protected static ?string $navigationLabel = 'AI Assistants';

    protected static ?string $title = 'AI Content & Operations Assistants';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.ai-tools';

    public ?array $generatorData = [];

    public ?array $troubleshootData = [];

    public string $generatorResult = '';

    public string $automationResult = '';

    public string $troubleshootResult = '';

    public function mount(): void
    {
        $this->generatorForm->fill([
            'type' => 'blog',
            'topic' => 'moisture detailing for fiber cement siding in Minnesota winters',
        ]);
        $this->troubleshootForm->fill([
            'issue' => 'Homeowner reports soft sheathing and bubbling paint behind vinyl siding',
        ]);
    }

    protected function getForms(): array
    {
        return [
            'generatorForm',
            'troubleshootForm',
        ];
    }

    public function generatorForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')->options([
                    'blog' => 'Blog / Knowledge post',
                    'service' => 'Service description',
                    'email' => 'Homeowner email',
                ])->required()->native(false),
                Forms\Components\Textarea::make('topic')->required()->rows(3),
            ])
            ->statePath('generatorData');
    }

    public function troubleshootForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('issue')->required()->rows(4)->label('Issue to diagnose'),
            ])
            ->statePath('troubleshootData');
    }

    public function generate(AiAssistantService $ai): void
    {
        $data = $this->generatorForm->getState();
        $this->generatorResult = $ai->generateContent($data['type'], $data['topic']);
        Notification::make()->title('Content generated')->success()->send();
    }

    public function suggestAutomations(AiAssistantService $ai): void
    {
        $this->automationResult = $ai->automationSuggestions();
        Notification::make()->title('Automation ideas ready')->success()->send();
    }

    public function runTroubleshoot(AiAssistantService $ai): void
    {
        $data = $this->troubleshootForm->getState();
        $this->troubleshootResult = $ai->troubleshoot($data['issue']);
        Notification::make()->title('Troubleshooting complete')->success()->send();
    }
}
