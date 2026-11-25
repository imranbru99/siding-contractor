<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeArticleResource\Pages;
use App\Models\KnowledgeArticle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KnowledgeArticleResource extends Resource
{
    protected static ?string $model = KnowledgeArticle::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Knowledge Base';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Forms\Components\Select::make('category')->options([
                'issues' => 'Common Issues',
                'guides' => 'Step-by-Step Guides',
                'admin' => 'Admin Manual',
                'troubleshooting' => 'Troubleshooting',
            ])->required()->native(false),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\TextInput::make('summary')->required()->maxLength(255)->columnSpanFull(),
            Forms\Components\RichEditor::make('body')->required()->columnSpanFull(),
            Forms\Components\Toggle::make('is_published')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
                Tables\Columns\BadgeColumn::make('category'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->defaultSort('sort_order')
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
            'index' => Pages\ListKnowledgeArticles::route('/'),
            'create' => Pages\CreateKnowledgeArticle::route('/create'),
            'edit' => Pages\EditKnowledgeArticle::route('/{record}/edit'),
        ];
    }
}
