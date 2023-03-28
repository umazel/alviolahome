<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\Loan;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LoanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LoanResource\RelationManagers;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('loan_date')
                    ->required()
                    ->unique(
                        ignoreRecord: true,
                        callback: function (Unique $rule,  Closure $get) {
                            return $rule->where('employee_id', $get('employee_id'));
                        }
                    ),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('loan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('loan_date')
                    ->date(),
                Tables\Columns\TextColumn::make('employee.name'),
                Tables\Columns\TextColumn::make('loan'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
