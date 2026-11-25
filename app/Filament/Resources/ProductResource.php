<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Inventory';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('sku')->required()->unique(ignoreRecord: true)->maxLength(100),
            Forms\Components\Select::make('category')->options([
                'framing' => 'Framing',
                'insulation' => 'Insulation',
                'drywall' => 'Drywall',
                'flooring' => 'Flooring',
                'electrical' => 'Electrical',
                'plumbing' => 'Plumbing',
                'waterproofing' => 'Waterproofing',
                'finish' => 'Finish Trim',
                'other' => 'Other',
            ])->searchable(),
            Forms\Components\TextInput::make('unit')->default('ea')->maxLength(20),
            Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('unit_cost')->numeric()->prefix('$')->required(),
            Forms\Components\TextInput::make('unit_price')->numeric()->prefix('$')->required(),
            Forms\Components\TextInput::make('stock_qty')->numeric()->required()->default(0),
            Forms\Components\Toggle::make('is_active')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('category'),
                Tables\Columns\TextColumn::make('stock_qty')->sortable()->label('Stock'),
                Tables\Columns\TextColumn::make('unit_price')->money('USD'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
