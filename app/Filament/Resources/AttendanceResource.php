<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Attendance;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Payroll';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('present_date')
                    ->required()
                    ->unique(
                        ignoreRecord: true,
                        callback: function (Unique $rule,  Closure $get) {
                            return $rule->where('employee_id', $get('employee_id'));
                        }
                    ),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name')
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
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.position')
                    ->label('Position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ot_hours')
                    ->label('OT hours'),
                Tables\Columns\TextColumn::make('ut_hours')
                    ->label('Late / UT hours'),
                Tables\Columns\TextColumn::make('assigned_work')
                    ->limit(50),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
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
