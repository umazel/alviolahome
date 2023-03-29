<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Loan;
use App\Models\Salary;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class LoanBalanceOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 1;

    public ?Model $record = null;

    protected function getCards(): array
    {
        return [
            Card::make(
                'Loan Balance',
                Loan::where('employee_id', $this->record->id)->pluck('loan')->sum()
                    - Salary::where('employee_id', $this->record->id)->pluck('loan_payment')->sum()
            ),
        ];
    }
}
