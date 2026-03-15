<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeDonationSummaryExport implements FromCollection, WithHeadings
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $request = new Request($this->filters);

        $query = Employee::query()
            ->leftJoin('donations', 'employees.id', '=', 'donations.employee_id')
            ->select(
                'employees.employee_no',
                'employees.full_name',
                'employees.department',
                DB::raw('COUNT(donations.id) as total_donations'),
                DB::raw('COALESCE(SUM(donations.amount), 0) as total_amount'),
                DB::raw('MAX(donations.donation_date) as latest_donation_date')
            )
            ->groupBy('employees.id', 'employees.employee_no', 'employees.full_name', 'employees.department');

        if ($request->filled('employee_id')) {
            $query->where('employees.id', $request->employee_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('donations.donation_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('donations.donation_date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('donations.status', $request->status);
        }

        return $query->orderByDesc('latest_donation_date')->get()->map(function ($row) {
            return [
                'Employee No'          => $row->employee_no,
                'Employee Name'        => $row->full_name,
                'Department'           => $row->department,
                'Total Donations'      => $row->total_donations,
                'Total Amount'         => $row->total_amount,
                'Latest Donation Date' => $row->latest_donation_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee No',
            'Employee Name',
            'Department',
            'Total Donations',
            'Total Amount',
            'Latest Donation Date',
        ];
    }
}
