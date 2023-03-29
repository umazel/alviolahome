<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use Carbon\Carbon;
use App\Models\Salary;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EmployeeStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 1;

    protected function getCards(): array
    {
        $latest_salary_date = Salary::max('salary_date');
        return [
            Card::make('Employees', Employee::all()->count()),
            Card::make('Salary Date: ' . Carbon::parse($latest_salary_date)->format('M j, Y'), Salary::where('salary_date', $latest_salary_date)->pluck('net_pay')->sum()),
        ];
    }
}
