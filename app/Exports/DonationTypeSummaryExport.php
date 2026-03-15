<?php

namespace App\Exports;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonationTypeSummaryExport implements FromCollection, WithHeadings
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $request = new Request($this->filters);

        $query = Donation::query()
            ->select(
                'donation_type',
                DB::raw('COUNT(id) as total_records'),
                DB::raw('COALESCE(SUM(amount), 0) as total_amount')
            )
            ->groupBy('donation_type');

        if ($request->filled('date_from')) {
            $query->whereDate('donation_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('donation_date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->orderBy('donation_type')->get()->map(function ($row) {
            return [
                'Donation Type' => $row->donation_type,
                'Total Records' => $row->total_records,
                'Total Amount'  => $row->total_amount,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Donation Type',
            'Total Records',
            'Total Amount',
        ];
    }
}
