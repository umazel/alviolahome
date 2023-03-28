<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoans extends ListRecords
{
    protected static string $resource = LoanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'loan_date';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
}
