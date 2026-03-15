<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeRelation extends Model
{
    protected $fillable = [
        'employee_id',
        'relation_type',
        'full_name',
        'dob',
        'phone',
        'occupation',
        'address',
        'notes',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
