<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query()->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('employee_no', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('nic', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', 'like', '%' . $request->department . '%');
        }

        $employees = $query->paginate(10)->withQueryString();

        return view('backend.pages.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('backend.pages.employees.create');
    }

    public function store(Request $request)
    {
        $validator = $this->employeeValidator($request);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $employee = Employee::create([
                'full_name'   => $request->full_name,
                'nic'         => $request->nic,
                'phone'       => $request->phone,
                'email'       => $request->email,
                'department'  => $request->department,
                'designation' => $request->designation,
                'status'      => $request->status,
                'remarks'     => $request->remarks,
            ]);

            $this->saveDynamicSections($employee, $request->dynamic_sections ?? []);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully.',
                'redirect' => route('admin.employees.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'errors' => ['system' => [$e->getMessage()]],
            ], 500);
        }
    }

    public function show($id)
    {
        $employee = Employee::with(['detailSections.fields'])->findOrFail($id);

        return view('backend.pages.employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::with(['detailSections.fields'])->findOrFail($id);

        return view('backend.pages.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validator = $this->employeeValidator($request, $employee->id);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $employee->update([
                'full_name'   => $request->full_name,
                'nic'         => $request->nic,
                'phone'       => $request->phone,
                'email'       => $request->email,
                'department'  => $request->department,
                'designation' => $request->designation,
                'status'      => $request->status,
                'remarks'     => $request->remarks,
            ]);

            $employee->detailSections()->delete();
            $this->saveDynamicSections($employee, $request->dynamic_sections ?? []);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully.',
                'redirect' => route('admin.employees.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'errors' => ['system' => [$e->getMessage()]],
            ], 500);
        }
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }

    private function employeeValidator(Request $request, $employeeId = null)
    {
        return Validator::make($request->all(), [
            'full_name'   => ['required', 'string', 'max:255'],
            'nic'         => ['nullable', 'string', 'max:255', Rule::unique('employees', 'nic')->ignore($employeeId)],
            'phone'       => ['nullable', 'string', 'max:50'],
            'email'       => ['nullable', 'email', 'max:255', Rule::unique('employees', 'email')->ignore($employeeId)],
            'department'  => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'status'      => ['required', 'in:Active,Inactive'],
            'remarks'     => ['nullable', 'string'],

            'dynamic_sections' => ['nullable', 'array'],
            'dynamic_sections.*.section_title' => ['nullable', 'string', 'max:255'],
            'dynamic_sections.*.fields' => ['nullable', 'array'],
            'dynamic_sections.*.fields.*.field_label' => ['nullable', 'string', 'max:255'],
            'dynamic_sections.*.fields.*.input_type' => ['nullable', 'in:text,number,date,textarea,email'],
            'dynamic_sections.*.fields.*.field_value' => ['nullable'],
        ]);
    }

    private function saveDynamicSections(Employee $employee, array $sections): void
    {
        foreach ($sections as $sectionIndex => $sectionData) {
            $sectionTitle = trim($sectionData['section_title'] ?? '');

            if ($sectionTitle === '') {
                continue;
            }

            $section = $employee->detailSections()->create([
                'section_title' => $sectionTitle,
                'sort_order'    => $sectionIndex,
            ]);

            $fields = $sectionData['fields'] ?? [];

            foreach ($fields as $fieldIndex => $fieldData) {
                $fieldLabel = trim($fieldData['field_label'] ?? '');
                $inputType  = $fieldData['input_type'] ?? 'text';
                $fieldValue = $fieldData['field_value'] ?? null;

                if ($fieldLabel === '' && (is_null($fieldValue) || $fieldValue === '')) {
                    continue;
                }

                $section->fields()->create([
                    'field_label' => $fieldLabel !== '' ? $fieldLabel : 'Field',
                    'input_type'  => in_array($inputType, ['text', 'number', 'date', 'textarea', 'email']) ? $inputType : 'text',
                    'field_value' => $fieldValue,
                    'sort_order'  => $fieldIndex,
                ]);
            }
        }
    }
}
