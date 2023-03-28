<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Salary;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SalaryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SalaryResource\RelationManagers;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('salary_date')
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
                    ->required()
                    ->reactive()
                    ->AfterStateUpdated(
                        function ($set, $state) {
                            $employee = Employee::find($state);
                            if ($employee) {
                                $set('rate', $employee->rate);
                            } else {
                                $set('rate', null);
                            }
                        }
                    ),
                Forms\Components\TextInput::make('rate')
                    ->minValue(0)
                    ->numeric()
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('work_days')
                    ->minValue(0)
                    ->numeric()
                    ->required(),
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
                Forms\Components\TextInput::make('ca_payment')
                    ->label('CA payment')
                    ->minValue(0)
                    ->default(0)
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('loan_payment')
                    ->minValue(0)
                    ->default(0)
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('salary_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name'),
                Tables\Columns\TextColumn::make('rate'),
                Tables\Columns\TextColumn::make('work_days'),
                Tables\Columns\TextColumn::make('ot_hours')
                    ->label('OT hours'),
                Tables\Columns\TextColumn::make('ut_hours')
                    ->label('Late / UT hours'),
                Tables\Columns\TextColumn::make('ca_payment')
                    ->label('CA payment'),
                Tables\Columns\TextColumn::make('loan_payment'),
                Tables\Columns\TextColumn::make('net_pay'),
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
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
