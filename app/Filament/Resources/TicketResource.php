<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers\CommentsRelationManager;
use App\Models\Priority;
use App\Models\Outlet;
use App\Models\ProblemCategory;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\Unit;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\DateRangeFilter;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Components\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\BadgeColumn;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        $openStatus = TicketStatus::where('name', 'Open')->first();
        $defaultValue = $openStatus ? $openStatus->id : null;
        $isCreating = empty(request()->route('record'));
        $isAdminUnit = auth()->user()->hasRole('Staff unit');
        $disableStatusField = ($isCreating && $isAdminUnit);
        $isCreatingByAdminUnit = $isCreating && $isAdminUnit;
        $jsScript = $isCreatingByAdminUnit ? <<<JS
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelector('select[name="ticket_statuses_id"]').disabled = true;
                });
            </script>
        JS : '';
        echo $jsScript;

        return $form->schema([
            Card::make()->schema([
                Forms\Components\Select::make('unit_id')
                    ->label(__('Devartement / Div'))
                    ->options(Unit::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $unit = Unit::find($state);
                        if ($unit) {
                            $problemCategoryId = (int)$get('problem_category_id');
                            if ($problemCategoryId && $problemCategory = ProblemCategory::find($problemCategoryId)) {
                                if ($problemCategory->unit_id !== $unit->id) {
                                    $set('problem_category_id', null);
                                }
                            }
                        }
                    })
                    ->reactive()
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin'])),
                    
                Forms\Components\Select::make('problem_category_id')
                    ->label(__('Problem Category'))
                    ->options(function (callable $get, callable $set) {
                        $unit = Unit::find($get('unit_id'));
                        if ($unit) {
                            return $unit->problemCategories->pluck('name', 'id');
                        }
                        return ProblemCategory::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin'])),
                    
                Forms\Components\TextInput::make('asset_number')
                    ->label(__('Asset Number'))
                    ->maxLength(255)
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin'])),
                Forms\Components\TextInput::make('serial_number')
                    ->label(__('Serial Number'))
                    ->maxLength(255)
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin'])),
                    
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['sm' => 2])
                    // ->hint('Jika memilih prioritas tinggi, tiket harus diperbarui dalam waktu 2 jam.')
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin'])),
                Forms\Components\SpatieMediaLibraryFileUpload::make('attachments')
                    ->label('Gambar')
                    ->columnSpan(['sm' => 2])
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin'])),
                Forms\Components\RichEditor::make('description')
                    ->label(__('Description'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(['sm' => 2])
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin']))
                    ->afterStateHydrated(function ($state) {
                        $state = strip_tags($state, '<a><b><i><u><strong><em>');
                    }),
                Forms\Components\Placeholder::make('approved_at')
                    ->translateLabel()
                    ->hiddenOn('create')
                    ->content(fn(?Ticket $record): string => $record->approved_at ? $record->approved_at->diffForHumans() : '-'),
                Forms\Components\Placeholder::make('solved_at')
                    ->translateLabel()
                    ->hiddenOn('create')
                    ->content(fn(?Ticket $record): string => $record->solved_at ? $record->solved_at->diffForHumans() : '-'),
            ])->columns(['sm' => 2])->columnSpan(2),
            Card::make()->schema([
                Forms\Components\Select::make('priority_id')
                    ->label(__('Priority'))
                    ->options(Priority::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        if ($state == Priority::HIGH) {
                            // Tambahkan pesan peringatan
                            session()->flash('message', 'Tiket dengan prioritas tinggi harus diperbarui dalam waktu 2 jam.');
                        }
                    })
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin'])),
                    
                    Forms\Components\Select::make('outlet_id')
                    ->label(__('Outlet'))
                    ->options(function () {
                        return Outlet::all()->mapWithKeys(function ($outlet) {
                            return [$outlet->id => $outlet->company_name . ' - ' . $outlet->name];
                        })->toArray();
                    })
                    ->searchable()
                    ->required()
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin', 'Staff unit'])),


                Forms\Components\Select::make('ticket_statuses_id')
                    ->label(__('Status'))
                    ->options(function () use ($defaultValue) {
                        $user = auth()->user();
                
                        if ($user->hasRole('Admin Unit')) {
                            $statuses = TicketStatus::whereIn('id', [
                                TicketStatus::OPEN,
                                TicketStatus::CLOSE,
                            ])->pluck('name', 'id')->toArray();
                        } elseif ($user->hasRole('Staff Unit')) {
                            $statuses = TicketStatus::whereNotIn('id', [
                                TicketStatus::CLOSE,
                            ])->pluck('name', 'id')->toArray();
                        } else {
                            $statuses = TicketStatus::pluck('name', 'id')->toArray();
                        }
                
                        if ($defaultValue === null) {
                            $statuses = ['Open' => 'Open'] + $statuses;
                        }
                
                        return $statuses;
                    })
                    ->searchable()
                    ->required()
                    ->default($defaultValue),
                


                    Forms\Components\Select::make('responsible_id')
                    ->label(__('Responsible'))
                    ->options(function (callable $get, callable $set) {
                        $user = auth()->user();
                        if ($user->hasAnyRole(['Super Admin', 'Admin Unit', 'Staff Unit'])) {
                            return User::with('unit')->get()->pluck('name', 'id');
                        } else {
                            return User::ByRole()->with('unit')->get()->pluck('name', 'id');
                        }
                    })
                    ->searchable()
                    ->required()
                    ->hiddenOn('create')
                    ->hidden(fn() => !auth()->user()->hasAnyRole(['Super Admin', 'Admin Unit', 'Staff Unit']))
                    ->disabled(!empty(request()->route('record')) && !auth()->user()->hasAnyRole(['Super Admin', 'Staff Unit']))
                    ->afterStateHydrated(function ($state, callable $set) {
                        $unitName = User::find($state)->unit->name ?? null;
                        $set('unit_name', $unitName);
                    }),

                    
                

                    
                Forms\Components\Placeholder::make('created_at')
                    ->translateLabel()
                    ->content(fn(?Ticket $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                Forms\Components\Placeholder::make('updated_at')
                    ->translateLabel()
                    ->content(fn(?Ticket $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                
            ])->columnSpan(1),
        ])->columns(3);
    }
 
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('problemCategory.name')
                ->searchable()
                ->label(__('Problem'))
                ->toggleable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('Created At'))
                ->dateTime()
                ->translateLabel()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('outlet.name')->label('Outlet'),
            Tables\Columns\TextColumn::make('responsible.name'),
            Tables\Columns\SpatieMediaLibraryImageColumn::make('attachments'),
            
            BadgeColumn::make('ticketStatus.name')
                ->label(__('Status'))
                ->sortable()
                ->color(function (string $state): string {
                    return match ($state) {
                        'Open' => 'primary',
                        'Pending' => 'warning',
                        'Close' => 'danger',
                        'Progres' => 'success',
                        default => 'secondary',
                    };
                }),
        ])->filters([
            Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from')->label(__('Created From')),
                    Forms\Components\DatePicker::make('created_until')->label(__('Created Until')),
                ])->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['created_from'],
                        fn($query, $date) => $query->whereDate('created_at', '>=', Carbon::parse($date))
                    )->when(
                        $data['created_until'],
                        fn($query, $date) => $query->whereDate('created_at', '<=', Carbon::parse($date))
                    );
                })->label(__('Created Date Range')),
        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            ExportBulkAction::make(),
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\ForceDeleteBulkAction::make(),
            Tables\Actions\RestoreBulkAction::make(),
        ])->defaultSort('created_at', 'desc');
    }



    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where(function ($query) {
            if (auth()->user()->hasRole('Super Admin')) {
                return;
            }
            if (auth()->user()->hasRole('Admin Unit')) {
                $query->where('tickets.unit_id', auth()->user()->unit_id)->orWhere('tickets.owner_id', auth()->id());
            } elseif (auth()->user()->hasRole('Staff Unit')) {
                $query->where('tickets.unit_id', auth()->user()->unit_id)->orWhere('tickets.owner_id', auth()->id());
            } elseif (auth()->user()->hasRole('user')) {
                $query->where('tickets.responsible_id', auth()->id())->orWhere('tickets.owner_id', auth()->id());
            } elseif (auth()->user()->hasRole('Pic')) {
                
            } else {
                $query->where('tickets.owner_id', auth()->id());
            }
        })->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tickets');
    }
}