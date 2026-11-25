<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Invoice;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Finance';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('invoice_id')
                ->label('Invoice')
                ->options(fn () => Invoice::query()->with('customer')->get()->mapWithKeys(
                    fn (Invoice $invoice) => [$invoice->id => $invoice->invoice_number.' — '.$invoice->customer?->name]
                ))
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('amount')->numeric()->prefix('$')->required(),
            Forms\Components\Select::make('method')->options([
                'check' => 'Check',
                'card' => 'Card',
                'ach' => 'ACH',
                'cash' => 'Cash',
                'other' => 'Other',
            ])->required()->native(false),
            Forms\Components\TextInput::make('reference')->maxLength(100),
            Forms\Components\DatePicker::make('paid_at')->required()->default(now()),
            Forms\Components\Textarea::make('notes')->rows(2)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice.invoice_number')->label('Invoice')->searchable(),
                Tables\Columns\TextColumn::make('amount')->money('USD')->sortable(),
                Tables\Columns\BadgeColumn::make('method'),
                Tables\Columns\TextColumn::make('reference'),
                Tables\Columns\TextColumn::make('paid_at')->date()->sortable(),
            ])
            ->defaultSort('paid_at', 'desc')
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
