<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function thirteenthmonths(): HasMany
    {
        return $this->hasMany(Thirteenthmonth::class);
    }
}
