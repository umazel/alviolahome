<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\EmployeeResource\Widgets\LoanBalanceOverview;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatsOverview;
use App\Filament\Resources\EmployeeResource\Widgets\ThirteenthmonthBalanceOverview;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            LoanBalanceOverview::class,
            ThirteenthmonthBalanceOverview::class,
        ];
    }
}
