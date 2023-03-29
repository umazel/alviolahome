<?php

namespace App\Filament\Resources\SalaryResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SalaryResource;
use App\Filament\Resources\EmployeeResource\Widgets\LoanBalanceOverview;
use App\Filament\Resources\EmployeeResource\Widgets\ThirteenthmonthBalanceOverview;

class EditSalary extends EditRecord
{
    protected static string $resource = SalaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            LoanBalanceOverview::class,
            ThirteenthmonthBalanceOverview::class,
        ];
    }
}
