<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use PhpParser\Node\Expr\Empty_;

class EmployeeStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 1;

    protected function getCards(): array
    {
        return [
            Card::make('Employees', Employee::all()->count()),
        ];
    }
}
