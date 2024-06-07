<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriorityResource\Pages;
use App\Models\Priority;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PriorityResource extends Resource
{
    protected static ?string $model = Priority::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label(__('Name'))
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('sla_hours')
                ->label(__('SLA Hours'))
                ->numeric()
                ->required()
                ->minValue(0),

            Forms\Components\Textarea::make('description')
                ->label(__('Description'))
                ->maxLength(500),

            Forms\Components\Toggle::make('is_active')
                ->label(__('Active'))
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('No'),

            Tables\Columns\TextColumn::make('name')
                ->translateLabel()
                ->searchable(),

            Tables\Columns\TextColumn::make('sla_hours')
                ->label(__('SLA Hours')),

            // Tables\Columns\TextColumn::make('created_at')
            //     ->label(__('Created At'))
            //     ->dateTime(),

            // Tables\Columns\TextColumn::make('sla_countdown')
            //     ->label(__('SLA Countdown'))
            //     ->getStateUsing(function ($record) {
            //         $createdAt = $record->created_at ? Carbon::parse($record->created_at) : null;
            //         $slaHours = $record->sla_hours;

            //         if (!$createdAt || !$slaHours) {
            //             return '';
            //         }   

            //         $slaEnd = $createdAt->copy()->addHours($slaHours);
            //         $now = Carbon::now();

            //         if ($now->greaterThanOrEqualTo($slaEnd)) {
            //             return 'Expired';
            //         }

            //         return $slaEnd->diffForHumans($now, ['parts' => 3, 'short' => true]);
            //     }),
        ])->filters([
            // Your filters
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            ExportBulkAction::make(),
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPriorities::route('/'),
            'create' => Pages\CreatePriority::route('/create'),
            'edit' => Pages\EditPriority::route('/{record}/edit'),
        ];
    }
}