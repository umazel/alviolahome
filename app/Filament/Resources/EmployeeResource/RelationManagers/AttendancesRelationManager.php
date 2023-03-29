<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $recordTitleAttribute = 'employee_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('present_date')
                    ->required()
                    ->unique(
                        ignoreRecord: true,
                        callback: function (Unique $rule, Component $livewire) {
                            return $rule->where('employee_id', $livewire->ownerRecord->id);
                        }
                    ),
                Forms\Components\TextInput::make('ot_hours')
                    ->label('Overtime hours')
                    ->minValue(0)
                    ->default(0)
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('ut_hours')
                    ->label('Late / Undertime hours')
                    ->minValue(0)
                    ->default(0)
                    ->numeric()
                    ->required(),
                Forms\Components\Textarea::make('assigned_work')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('present_date')
                    ->date(),
                Tables\Columns\TextColumn::make('ot_hours')
                    ->label('OT hours'),
                Tables\Columns\TextColumn::make('ut_hours')
                    ->label('Late / UT hours'),
                Tables\Columns\TextColumn::make('assigned_work')
                    ->limit(70),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('present_date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from'),
                        Forms\Components\DatePicker::make('date_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('present_date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('present_date', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'present_date';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
}
