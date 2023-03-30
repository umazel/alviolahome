<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Employee;
use App\Models\Salary;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Thirteenthmonth;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ThirteenthmonthBalanceOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 1;

    public ?Model $record = null;

    protected function getCards(): array
    {
        return [
            Card::make(
                '13ᵗʰ Month Pay Available',
                round(Salary::where('employee_id', $this->record->id)->pluck('gross_pay')->sum() / 12)
                    - Thirteenthmonth::where('employee_id', $this->record->id)->pluck('thirteenthmonth_pay')->sum()
            ),
        ];
    }
}
