<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'employee_no',
        'rec_date',
        'join_date',
        'full_name',
        'name_with_initials',
        'dob',
        'age',
        'nic',
        'phone',
        'email',
        'address',
        'district',
        'gs_division',
        'police_station',
        'nationality',
        'religion',

        'service_number',
        'rank',
        'site_location',
        'vo',
        'department',
        'designation',

        'close_relation',
        'relationship',
        'cr_contact',

        'education',
        'other_qualification',
        'previous_experience',
        'experience_period',

        'bank_name',
        'account_number',
        'branch',
        'salary',

        'doc_m_um',
        'doc_pension',
        'doc_i_al',
        'doc_2_ca',
        'doc_3_wcl',
        'doc_4_nic_c',
        'doc_5_bc',
        'doc_6_gnc',
        'doc_7_pr',
        'doc_8_ec',
        'doc_9_qc',
        'doc_10_chc',
        'doc_11_po',
        'doc_12_fp',
        'doc_13_ba',

        'status',
        'remarks',
    ];

    protected $casts = [
        'rec_date' => 'date',
        'join_date' => 'date',
        'dob' => 'date',
        'salary' => 'decimal:2',

        'doc_m_um' => 'boolean',
        'doc_pension' => 'boolean',
        'doc_i_al' => 'boolean',
        'doc_2_ca' => 'boolean',
        'doc_3_wcl' => 'boolean',
        'doc_4_nic_c' => 'boolean',
        'doc_5_bc' => 'boolean',
        'doc_6_gnc' => 'boolean',
        'doc_7_pr' => 'boolean',
        'doc_8_ec' => 'boolean',
        'doc_9_qc' => 'boolean',
        'doc_10_chc' => 'boolean',
        'doc_11_po' => 'boolean',
        'doc_12_fp' => 'boolean',
        'doc_13_ba' => 'boolean',
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