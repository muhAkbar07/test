<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutletResource\Pages;
use App\Models\Outlet;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OutletImport;
use App\Exports\OutletExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutletResource extends Resource
{
    protected static ?string $model = Outlet::class;

    protected static ?string $navigationIcon = 'heroicon-o-library';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('outlet_code')
                    ->label('Code Outlet')
                    ->required(),
                    
                Forms\Components\Select::make('company_name')
                    ->label('Nama PT')
                    ->options([
                        'GJB' => 'GJB',
                        'ATG' => 'ATG',
                        'GEJ' => 'GEJ',
                        'SIG' => 'SIG',
                        'IJG' => 'IJG',
                        'KDG' => 'KDG',
                        'SAG' => 'SAG',
                        'LWG' => 'LWG',
                    ])
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Outlet')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('outlet_code')
                    ->label('Code Outlet')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Nama PT'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Outlet')
                    ->searchable(),
            ])
            ->filters([])   
            ->headerActions([
                Tables\Actions\Action::make('totalCount')
                    ->label(fn () => 'Total: ' . Outlet::count())
                    ->color('primary')
                    ->icon('heroicon-o-information-circle')
                    ->action(fn () => null),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('export')
                    ->label('Export')
                    ->action(function ($records) {
                        $recordIds = $records->pluck('id')->toArray();
                        return Excel::download(new OutletExport($recordIds), 'outlets.xlsx');
                    }),
                BulkAction::make('import')
                    ->label('Import')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label('Select File')
                            ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        try {
                            $filePath = $data['file']->store('imports');
                            Excel::import(new OutletImport, Storage::path($filePath));
                        } catch (\Exception $e) {
                            return response()->json(['error' => $e->getMessage()], 500);
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutlets::route('/'),
            'create' => Pages\CreateOutlet::route('/create'),
            'edit' => Pages\EditOutlet::route('/{record}/edit'),
            'view' => Pages\ViewOutlet::route('/{record}'),
        ];
    }
}