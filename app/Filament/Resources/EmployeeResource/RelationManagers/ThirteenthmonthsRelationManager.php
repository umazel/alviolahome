<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ThirteenthmonthsRelationManager extends RelationManager
{
    protected static string $relationship = 'thirteenthmonths';

    protected static ?string $modelLabel = '13ᵗʰ Month Pay';
    protected static ?string $pluralModelLabel = '13ᵗʰ Month Pays';


    protected static ?string $recordTitleAttribute = 'employee_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('thirteenthmonth_date')
                    ->label('13ᵗʰ Month Pay date')
                    ->required()
                    ->unique(
                        ignoreRecord: true,
                        callback: function (Unique $rule, Component $livewire) {
                            return $rule->where('employee_id', $livewire->ownerRecord->id);
                        }
                    ),
                Forms\Components\TextInput::make('thirteenthmonth_pay')
                    ->label('13ᵗʰ Month Pay')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('thirteenthmonth_date')
                    ->label('13ᵗʰ Month Pay date')
                    ->date(),
                Tables\Columns\TextColumn::make('thirteenthmonth_pay')
                    ->label('13ᵗʰ Month Pay'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
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
        return 'thirteenthmonth_date';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
}
