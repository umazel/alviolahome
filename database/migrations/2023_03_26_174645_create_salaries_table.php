<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->date('salary_date');
            $table->foreignIdFor(Employee::class);
            $table->double('rate');
            $table->double('work_days');
            $table->double('ot_hours');
            $table->double('ut_hours');
            $table->double('cash_advance_payment');
            $table->double('loan_payment');
            $table->double('gross_pay')
                ->storedAs(
                    'rate * work_days
                    + round(rate * work_days / 8 * ot_hours,0)
                    - round(rate * work_days / 8 * ut_hours,0)'
                );
            $table->double('net_pay')->storedAs('gross_pay - cash_advance_payment - loan_payment');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
