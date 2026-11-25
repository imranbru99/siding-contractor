<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Company Settings';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => Setting::getValue('company_name', 'Northclad Siding Co.'),
            'company_phone' => Setting::getValue('company_phone', '(612) 555-0184'),
            'company_email' => Setting::getValue('company_email', 'hello@northclad.example'),
            'company_address' => Setting::getValue('company_address', '1840 Marshall St NE, Minneapolis, MN 55413'),
            'whatsapp_number' => Setting::getValue('whatsapp_number', '16125550184'),
            'service_area' => Setting::getValue('service_area', 'Minneapolis–Saint Paul metro — Minneapolis, Saint Paul, Edina, Bloomington, Plymouth, Maple Grove, and surrounding suburbs'),
            'tagline' => Setting::getValue('tagline', 'Weather-tight cladding for Twin Cities homes'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')->required(),
                Forms\Components\TextInput::make('tagline')->required(),
                Forms\Components\TextInput::make('company_phone')->required(),
                Forms\Components\TextInput::make('company_email')->email()->required(),
                Forms\Components\TextInput::make('whatsapp_number')->helperText('Digits only for wa.me links'),
                Forms\Components\Textarea::make('company_address')->rows(2),
                Forms\Components\Textarea::make('service_area')->rows(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        foreach ($state as $key => $value) {
            Setting::setValue($key, $value, 'company');
        }

        Notification::make()->title('Settings saved')->success()->send();
    }
}
