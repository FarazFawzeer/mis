<?php

namespace App\Exports;

use App\Models\Donation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonationDetailedReportExport implements FromCollection, WithHeadings
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $request = new Request($this->filters);

        $query = Donation::with('employee');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('beneficiary_name', 'like', "%{$search}%")
                    ->orWhere('donation_type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('remarks', 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('employee_no', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('donation_type')) {
            $query->where('donation_type', 'like', '%' . $request->donation_type . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('donation_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('donation_date', '<=', $request->date_to);
        }

        return $query->orderBy('donation_date', 'desc')->get()->map(function ($row) {
            return [
                'Donation Date'   => optional($row->donation_date)->format('Y-m-d'),
                'Employee No'     => optional($row->employee)->employee_no ?? '-',
                'Employee Name'   => optional($row->employee)->full_name ?? '-',
                'Beneficiary'     => $row->beneficiary_name,
                'Donation Type'   => $row->donation_type,
                'Amount'          => $row->amount,
                'Status'          => $row->status,
                'Description'     => $row->description,
                'Remarks'         => $row->remarks,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Donation Date',
            'Employee No',
            'Employee Name',
            'Beneficiary',
            'Donation Type',
            'Amount',
            'Status',
            'Description',
            'Remarks',
        ];
    }
}
