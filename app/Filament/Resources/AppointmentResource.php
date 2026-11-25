<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable()->preload(),
            Forms\Components\Select::make('project_id')->relationship('project', 'title')->searchable()->preload(),
            Forms\Components\Select::make('assigned_to')->relationship('assignee', 'name')->searchable()->preload(),
            Forms\Components\Select::make('type')->options([
                'consultation' => 'Consultation',
                'site_visit' => 'Site Visit',
                'install' => 'Install / Crew Day',
                'punch_list' => 'Punch List',
                'follow_up' => 'Follow Up',
            ])->required()->native(false),
            Forms\Components\Select::make('status')->options([
                'scheduled' => 'Scheduled',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
                'no_show' => 'No Show',
            ])->default('scheduled')->native(false),
            Forms\Components\DateTimePicker::make('starts_at')->required(),
            Forms\Components\DateTimePicker::make('ends_at'),
            Forms\Components\TextInput::make('location')->maxLength(255)->columnSpanFull(),
            Forms\Components\Textarea::make('notes')->rows(3)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('starts_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(28),
                Tables\Columns\TextColumn::make('customer.name'),
                Tables\Columns\BadgeColumn::make('type'),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('assignee.name')->label('Assigned'),
            ])
            ->defaultSort('starts_at')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
