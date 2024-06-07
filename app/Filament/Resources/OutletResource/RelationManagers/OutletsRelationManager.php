<?php

namespace App\Filament\Resources\OutletResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\Outlet;

class OutletRelationManager extends RelationManager
{
    protected static string $relationship = 'outlets';

    protected static ?string $recordTitleAttribute = 'title';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('problemCategory.name')
                    ->searchable()
                    ->label(__('Problem Category'))
                    ->toggleable(),
                // Uncomment and use this if needed, ensuring consistency in translation
                // Tables\Columns\TextColumn::make('ticketStatus.name')
                //     ->label(__('Status'))
                //     ->sortable(),
            ])
            ->filters([])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Outlet $record): string => route('filament.resources.outlets.view', $record)),
            ])
            ->bulkActions([]);
    }
}