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
                    ->orWhere('name_with_initials', 'like', "%{$search}%")
                    ->orWhere('nic', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('service_number', 'like', "%{$search}%")
                    ->orWhere('rank', 'like', "%{$search}%")
                    ->orWhere('site_location', 'like', "%{$search}%")
                    ->orWhere('vo', 'like', "%{$search}%")
                    ->orWhere('education', 'like', "%{$search}%")
                    ->orWhere('cr_contact', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', 'like', '%' . $request->department . '%');
        }

        if ($request->filled('district')) {
            $query->where('district', 'like', '%' . $request->district . '%');
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
            $employee = Employee::create($this->employeeData($request));

            $this->saveDynamicSections($employee, $request->input('dynamic_sections', []));

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
                'errors' => [
                    'system' => [$e->getMessage()]
                ],
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
            $employee->update($this->employeeData($request));

            $employee->detailSections()->delete();
            $this->saveDynamicSections($employee, $request->input('dynamic_sections', []));

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
                'errors' => [
                    'system' => [$e->getMessage()]
                ],
            ], 500);
        }
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }

    private function employeeData(Request $request): array
    {
        return [
            'rec_date'           => $request->input('rec_date') ?: null,
            'join_date'          => $request->input('join_date') ?: null,
            'full_name'          => $request->input('full_name'),
            'name_with_initials' => $request->input('name_with_initials') ?: null,
            'dob'                => $request->input('dob') ?: null,
            'age'                => $request->filled('age') ? (int) $request->input('age') : null,
            'nic'                => $request->input('nic') ?: null,
            'phone'              => $request->input('phone') ?: null,
            'email'              => $request->input('email') ?: null,
            'address'            => $request->input('address') ?: null,
            'district'           => $request->input('district') ?: null,
            'gs_division'        => $request->input('gs_division') ?: null,
            'police_station'     => $request->input('police_station') ?: null,
            'nationality'        => $request->input('nationality') ?: null,
            'religion'           => $request->input('religion') ?: null,

            'service_number'     => $request->input('service_number') ?: null,
            'rank'               => $request->input('rank') ?: null,
            'site_location'      => $request->input('site_location') ?: null,
            'vo'                 => $request->input('vo') ?: null,
            'department'         => $request->input('department') ?: null,
            'designation'        => $request->input('designation') ?: null,

            'close_relation'     => $request->input('close_relation') ?: null,
            'relationship'       => $request->input('relationship') ?: null,
            'cr_contact'         => $request->input('cr_contact') ?: null,

            'education'          => $request->input('education') ?: null,
            'other_qualification'=> $request->input('other_qualification') ?: null,
            'previous_experience'=> $request->input('previous_experience') ?: null,
            'experience_period'  => $request->input('experience_period') ?: null,

            'bank_name'          => $request->input('bank_name') ?: null,
            'account_number'     => $request->input('account_number') ?: null,
            'branch'             => $request->input('branch') ?: null,
            'salary'             => $request->filled('salary') ? $request->input('salary') : null,

            'doc_m_um'           => $request->boolean('doc_m_um'),
            'doc_pension'        => $request->boolean('doc_pension'),
            'doc_i_al'           => $request->boolean('doc_i_al'),
            'doc_2_ca'           => $request->boolean('doc_2_ca'),
            'doc_3_wcl'          => $request->boolean('doc_3_wcl'),
            'doc_4_nic_c'        => $request->boolean('doc_4_nic_c'),
            'doc_5_bc'           => $request->boolean('doc_5_bc'),
            'doc_6_gnc'          => $request->boolean('doc_6_gnc'),
            'doc_7_pr'           => $request->boolean('doc_7_pr'),
            'doc_8_ec'           => $request->boolean('doc_8_ec'),
            'doc_9_qc'           => $request->boolean('doc_9_qc'),
            'doc_10_chc'         => $request->boolean('doc_10_chc'),
            'doc_11_po'          => $request->boolean('doc_11_po'),
            'doc_12_fp'          => $request->boolean('doc_12_fp'),
            'doc_13_ba'          => $request->boolean('doc_13_ba'),

            'status'             => $request->input('status'),
            'remarks'            => $request->input('remarks') ?: null,
        ];
    }

    private function employeeValidator(Request $request, $employeeId = null)
    {
        return Validator::make($request->all(), [
            'rec_date'            => ['nullable', 'date'],
            'join_date'           => ['nullable', 'date'],
            'full_name'           => ['required', 'string', 'max:255'],
            'name_with_initials'  => ['nullable', 'string', 'max:255'],
            'dob'                 => ['nullable', 'date'],
            'age'                 => ['nullable', 'integer', 'min:0'],
            'nic'                 => ['nullable', 'string', 'max:255', Rule::unique('employees', 'nic')->ignore($employeeId)],
            'phone'               => ['nullable', 'string', 'max:50'],
            'email'               => ['nullable', 'email', 'max:255', Rule::unique('employees', 'email')->ignore($employeeId)],
            'address'             => ['nullable', 'string'],
            'district'            => ['nullable', 'string', 'max:255'],
            'gs_division'         => ['nullable', 'string', 'max:255'],
            'police_station'      => ['nullable', 'string', 'max:255'],
            'nationality'         => ['nullable', 'string', 'max:255'],
            'religion'            => ['nullable', 'string', 'max:255'],

            'service_number'      => ['nullable', 'string', 'max:255'],
            'rank'                => ['nullable', 'string', 'max:255'],
            'site_location'       => ['nullable', 'string', 'max:255'],
            'vo'                  => ['nullable', 'string', 'max:255'],
            'department'          => ['nullable', 'string', 'max:255'],
            'designation'         => ['nullable', 'string', 'max:255'],

            'close_relation'      => ['nullable', 'string', 'max:255'],
            'relationship'        => ['nullable', 'string', 'max:255'],
            'cr_contact'          => ['nullable', 'string', 'max:255'],

            'education'           => ['nullable', 'string', 'max:255'],
            'other_qualification' => ['nullable', 'string', 'max:255'],
            'previous_experience' => ['nullable', 'string'],
            'experience_period'   => ['nullable', 'string', 'max:255'],

            'bank_name'           => ['nullable', 'string', 'max:255'],
            'account_number'      => ['nullable', 'string', 'max:255'],
            'branch'              => ['nullable', 'string', 'max:255'],
            'salary'              => ['nullable', 'numeric', 'min:0'],

            'status'              => ['required', 'in:Active,Inactive'],
            'remarks'             => ['nullable', 'string'],

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