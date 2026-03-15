<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDetailField extends Model
{
    protected $fillable = [
        'employee_detail_section_id',
        'field_label',
        'input_type',
        'field_value',
        'sort_order',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(EmployeeDetailSection::class, 'employee_detail_section_id');
    }
}
