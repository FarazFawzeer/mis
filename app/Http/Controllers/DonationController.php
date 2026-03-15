<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with('employee')->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('beneficiary_name', 'like', "%{$search}%")
                    ->orWhere('donation_type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('employee_no', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('donation_type')) {
            $query->where('donation_type', 'like', '%' . $request->donation_type . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('donation_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('donation_date', '<=', $request->date_to);
        }

        $donations = $query->paginate(10)->withQueryString();

        return view('backend.pages.donations.index', compact('donations'));
    }

    public function create()
    {
        $employees = Employee::orderBy('full_name')->get(['id', 'employee_no', 'full_name']);

        return view('backend.pages.donations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validator = $this->donationValidator($request);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            Donation::create([
                'employee_id'       => $request->employee_id ?: null,
                'beneficiary_name'  => $request->beneficiary_name,
                'donation_type'     => $request->donation_type,
                'amount'            => $request->amount ?: null,
                'donation_date'     => $request->donation_date,
                'description'       => $request->description,
                'remarks'           => $request->remarks,
                'status'            => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Donation created successfully.',
                'redirect' => route('admin.donations.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => ['system' => [$e->getMessage()]],
            ], 500);
        }
    }

    public function show($id)
    {
        $donation = Donation::with('employee')->findOrFail($id);

        return view('backend.pages.donations.show', compact('donation'));
    }

    public function edit($id)
    {
        $donation = Donation::findOrFail($id);
        $employees = Employee::orderBy('full_name')->get(['id', 'employee_no', 'full_name']);

        return view('backend.pages.donations.edit', compact('donation', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $validator = $this->donationValidator($request);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $donation->update([
                'employee_id'       => $request->employee_id ?: null,
                'beneficiary_name'  => $request->beneficiary_name,
                'donation_type'     => $request->donation_type,
                'amount'            => $request->amount ?: null,
                'donation_date'     => $request->donation_date,
                'description'       => $request->description,
                'remarks'           => $request->remarks,
                'status'            => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Donation updated successfully.',
                'redirect' => route('admin.donations.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => ['system' => [$e->getMessage()]],
            ], 500);
        }
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return redirect()->route('admin.donations.index')->with('success', 'Donation deleted successfully.');
    }

    public function receiptPdf($id)
    {
        $donation = Donation::with('employee')->findOrFail($id);

        $receiptNo = 'DON-REC-' . str_pad($donation->id, 6, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('backend.pages.donations.receipt-pdf', compact('donation', 'receiptNo'))
            ->setPaper('a4', 'portrait');

        return $pdf->download($receiptNo . '.pdf');
    }

    private function donationValidator(Request $request)
    {
        return Validator::make($request->all(), [
            'employee_id'      => ['nullable', 'exists:employees,id'],
            'beneficiary_name' => ['required', 'string', 'max:255'],
            'donation_type'    => ['required', 'string', 'max:255'],
            'amount'           => ['nullable', 'numeric', 'min:0'],
            'donation_date'    => ['required', 'date'],
            'description'      => ['nullable', 'string'],
            'remarks'          => ['nullable', 'string'],
            'status'           => ['required', Rule::in(['Pending', 'Approved', 'Completed', 'Cancelled'])],
        ]);
    }
}
