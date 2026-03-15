<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployeeDetailSection extends Model
{
    protected $fillable = [
        'employee_id',
        'section_title',
        'sort_order',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(EmployeeDetailField::class)->orderBy('sort_order');
    }
}
