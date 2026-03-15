<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeMasterReportExport implements FromCollection, WithHeadings
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $request = new Request($this->filters);

        $query = Employee::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('employee_no', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('nic', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', 'like', '%' . $request->department . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->orderBy('full_name')->get()->map(function ($row) {
            return [
                'Employee No' => $row->employee_no,
                'Full Name'   => $row->full_name,
                'NIC'         => $row->nic,
                'Phone'       => $row->phone,
                'Email'       => $row->email,
                'Department'  => $row->department,
                'Designation' => $row->designation,
                'Status'      => $row->status,
                'Created At'  => optional($row->created_at)->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee No',
            'Full Name',
            'NIC',
            'Phone',
            'Email',
            'Department',
            'Designation',
            'Status',
            'Created At',
        ];
    }
}
