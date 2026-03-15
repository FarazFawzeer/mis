<?php

namespace App\Http\Controllers;

use App\Exports\DonationDetailedReportExport;
use App\Exports\DonationTypeSummaryExport;
use App\Exports\EmployeeDonationSummaryExport;
use App\Exports\EmployeeMasterReportExport;
use App\Models\Donation;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function donationDetailedReport(Request $request)
    {
        $employees = Employee::orderBy('full_name')->get(['id', 'employee_no', 'full_name']);

        $query = Donation::with('employee');

        $this->applyDonationFilters($query, $request);

        $donations = $query->orderBy('donation_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $summaryQuery = Donation::query();
        $this->applyDonationFilters($summaryQuery, $request);

        $summary = [
            'total_records' => (clone $summaryQuery)->count(),
            'total_amount' => (clone $summaryQuery)->sum('amount'),
            'completed_count' => (clone $summaryQuery)->where('status', 'Completed')->count(),
            'pending_count' => (clone $summaryQuery)->where('status', 'Pending')->count(),
        ];

        return view('backend.pages.reports.donation-detailed', compact('donations', 'employees', 'summary'));
    }

    public function employeeDonationSummary(Request $request)
    {
        $employees = Employee::orderBy('full_name')->get(['id', 'employee_no', 'full_name']);

        $query = Employee::query()
            ->leftJoin('donations', 'employees.id', '=', 'donations.employee_id')
            ->select(
                'employees.id',
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

        $rows = $query->orderByDesc('latest_donation_date')->paginate(15)->withQueryString();

        return view('backend.pages.reports.employee-donation-summary', compact('rows', 'employees'));
    }

    public function donationTypeSummary(Request $request)
    {
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

        $rows = $query->orderBy('donation_type')->paginate(15)->withQueryString();

        return view('backend.pages.reports.donation-type-summary', compact('rows'));
    }

    public function employeeMasterReport(Request $request)
    {
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

        $rows = $query->orderBy('full_name')->paginate(15)->withQueryString();

        return view('backend.pages.reports.employee-master', compact('rows'));
    }

    public function exportDonationDetailedExcel(Request $request)
    {
        return Excel::download(
            new DonationDetailedReportExport($request->all()),
            'donation-detailed-report.xlsx'
        );
    }

    public function exportDonationDetailedPdf(Request $request)
    {
        $query = Donation::with('employee');
        $this->applyDonationFilters($query, $request);

        $rows = $query->orderBy('donation_date', 'desc')->get();

        $pdf = Pdf::loadView('backend.pages.reports.pdf.donation-detailed-pdf', [
            'rows' => $rows,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('donation-detailed-report.pdf');
    }

    public function exportEmployeeDonationSummaryExcel(Request $request)
    {
        return Excel::download(
            new EmployeeDonationSummaryExport($request->all()),
            'employee-donation-summary.xlsx'
        );
    }

    public function exportEmployeeDonationSummaryPdf(Request $request)
    {
        $rows = $this->getEmployeeDonationSummaryCollection($request);

        $pdf = Pdf::loadView('backend.pages.reports.pdf.employee-donation-summary-pdf', [
            'rows' => $rows,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('employee-donation-summary.pdf');
    }

    public function exportDonationTypeSummaryExcel(Request $request)
    {
        return Excel::download(
            new DonationTypeSummaryExport($request->all()),
            'donation-type-summary.xlsx'
        );
    }

    public function exportDonationTypeSummaryPdf(Request $request)
    {
        $rows = $this->getDonationTypeSummaryCollection($request);

        $pdf = Pdf::loadView('backend.pages.reports.pdf.donation-type-summary-pdf', [
            'rows' => $rows,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('donation-type-summary.pdf');
    }

    public function exportEmployeeMasterExcel(Request $request)
    {
        return Excel::download(
            new EmployeeMasterReportExport($request->all()),
            'employee-master-report.xlsx'
        );
    }

    public function exportEmployeeMasterPdf(Request $request)
    {
        $rows = $this->getEmployeeMasterCollection($request);

        $pdf = Pdf::loadView('backend.pages.reports.pdf.employee-master-pdf', [
            'rows' => $rows,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('employee-master-report.pdf');
    }

    private function applyDonationFilters($query, Request $request): void
    {
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
    }

    private function getEmployeeDonationSummaryCollection(Request $request)
    {
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

        return $query->orderByDesc('latest_donation_date')->get();
    }

    private function getDonationTypeSummaryCollection(Request $request)
    {
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

        return $query->orderBy('donation_type')->get();
    }

    private function getEmployeeMasterCollection(Request $request)
    {
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

        return $query->orderBy('full_name')->get();
    }
}
