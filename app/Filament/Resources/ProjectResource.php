<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Jobs / Projects';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('project_number')->required()->unique(ignoreRecord: true)->maxLength(50),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable()->required()->preload(),
            Forms\Components\Select::make('assigned_to')->relationship('assignee', 'name')->searchable()->preload(),
            Forms\Components\TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
            Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
            Forms\Components\Select::make('status')->options([
                'lead' => 'Lead',
                'quoted' => 'Quoted',
                'scheduled' => 'Scheduled',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])->required()->native(false),
            Forms\Components\Select::make('priority')->options([
                'low' => 'Low',
                'normal' => 'Normal',
                'high' => 'High',
                'urgent' => 'Urgent',
            ])->default('normal')->native(false),
            Forms\Components\TextInput::make('site_address')->maxLength(255)->columnSpanFull(),
            Forms\Components\TextInput::make('sqft')->numeric()->suffix('sq ft'),
            Forms\Components\TextInput::make('estimated_value')->numeric()->prefix('$'),
            Forms\Components\TextInput::make('actual_value')->numeric()->prefix('$'),
            Forms\Components\DatePicker::make('start_date'),
            Forms\Components\DatePicker::make('target_date'),
            Forms\Components\DatePicker::make('completed_at'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_number')->searchable()->sortable()->label('#'),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('customer.name')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'gray' => 'lead',
                    'info' => 'quoted',
                    'warning' => 'scheduled',
                    'primary' => 'in_progress',
                    'success' => 'completed',
                    'danger' => 'cancelled',
                ]),
                Tables\Columns\TextColumn::make('sqft')->suffix(' sf'),
                Tables\Columns\TextColumn::make('estimated_value')->money('USD'),
                Tables\Columns\TextColumn::make('target_date')->date(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'lead' => 'Lead',
                    'quoted' => 'Quoted',
                    'scheduled' => 'Scheduled',
                    'in_progress' => 'In Progress',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ]),
            ])
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
