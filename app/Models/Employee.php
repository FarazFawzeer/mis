<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'employee_no',
        'full_name',
        'nic',
        'phone',
        'email',
        'department',
        'designation',
        'status',
        'remarks',
    ];

    protected static function booted()
    {
        static::created(function ($employee) {
            if (empty($employee->employee_no)) {
                $employee->updateQuietly([
                    'employee_no' => 'EMP-' . str_pad($employee->id, 5, '0', STR_PAD_LEFT),
                ]);
            }
        });
    }

    public function detailSections(): HasMany
    {
        return $this->hasMany(EmployeeDetailSection::class)->orderBy('sort_order');
    }
}
