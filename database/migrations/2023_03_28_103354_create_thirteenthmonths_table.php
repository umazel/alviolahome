<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thirteenthmonths', function (Blueprint $table) {
            $table->id();
            $table->date('thirteenthmonth_date');
            $table->foreignIdFor(Employee::class);
            $table->double('thirteenthmonth_pay');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thirteenthmonths');
    }
};
