<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Filament\Resources\EmployeeResource\RelationManagers\LoansRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\SalariesRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\AttendancesRelationManager;
use App\Filament\Resources\EmployeeResource\RelationManagers\ThirteenthmonthsRelationManager;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatsOverview;
use App\Filament\Resources\EmployeeResource\Widgets\LoanBalanceOverview;
use App\Filament\Resources\EmployeeResource\Widgets\ThirteenthmonthBalanceOverview;
use App\Models\Thirteenthmonth;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Payroll';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('rate')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Forms\Components\TextInput::make('position')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birthday'),
                Forms\Components\DatePicker::make('date_hired'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rate'),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->date(),
                Tables\Columns\TextColumn::make('date_hired')
                    ->date(),
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
            AttendancesRelationManager::class,
            SalariesRelationManager::class,
            LoansRelationManager::class,
            ThirteenthmonthsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            EmployeeStatsOverview::class,
            ThirteenthmonthBalanceOverview::class,
            LoanBalanceOverview::class,
        ];
    }
}
