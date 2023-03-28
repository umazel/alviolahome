<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\Thirteenthmonth;
use Filament\Resources\Resource;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ThirteenthmonthResource\Pages;
use App\Filament\Resources\ThirteenthmonthResource\RelationManagers;

class ThirteenthmonthResource extends Resource
{
    protected static ?string $model = Thirteenthmonth::class;

    protected static ?string $modelLabel = '13ᵗʰ Month Pay';

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('thirteenthmonth_date')
                    ->label('Date')
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
                    ->label('Date')
                    ->date(),
                Tables\Columns\TextColumn::make('employee.name'),
                Tables\Columns\TextColumn::make('thirteenthmonth_pay')
                    ->label('13ᵗʰ Month Pay'),
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
            'index' => Pages\ListThirteenthmonths::route('/'),
            'create' => Pages\CreateThirteenthmonth::route('/create'),
            'edit' => Pages\EditThirteenthmonth::route('/{record}/edit'),
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
