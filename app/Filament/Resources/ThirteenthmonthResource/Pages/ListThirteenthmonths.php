<?php

namespace App\Filament\Resources\ThirteenthmonthResource\Pages;

use App\Filament\Resources\ThirteenthmonthResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThirteenthmonths extends ListRecords
{
    protected static string $resource = ThirteenthmonthResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
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
