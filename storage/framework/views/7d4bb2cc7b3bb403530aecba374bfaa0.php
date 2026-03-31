

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Employees', 'subtitle' => 'Edit'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        .employee-form-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            overflow: hidden;
        }

        .employee-form-card .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 18px 22px;
        }

        .employee-form-card .card-body {
            padding: 24px;
        }

        .form-section {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 20px;
            background: #fff;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-subtitle {
            font-size: 12px;
            color: #6c757d;
            margin-top: -8px;
            margin-bottom: 16px;
        }

        .dynamic-section-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .dynamic-section-card .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 18px;
        }

        .dynamic-section-card .card-body {
            padding: 18px;
        }

        .field-row {
            background: #fafafa;
        }

        .checklist-box {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            padding: 14px 14px 6px;
            background: #fafafa;
        }

        .checklist-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #212529;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .sticky-submit-bar {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        @media (max-width: 768px) {
            .employee-form-card .card-body {
                padding: 16px;
            }

            .form-section {
                padding: 14px;
            }
        }
    </style>

    <div class="card employee-form-card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Employee</h5>
        </div>

        <div class="card-body">
            <div id="message"></div>

            <form id="editEmployeeForm" action="<?php echo e(route('admin.employees.update', $employee->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:user-id-outline"></iconify-icon>
                        Basic Employee Details
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Employee Number</label>
                            <input type="text" class="form-control" value="<?php echo e($employee->employee_no); ?>" readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Record Date</label>
                            <input type="date" name="rec_date" class="form-control"
                                value="<?php echo e(optional($employee->rec_date)->format('Y-m-d')); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Join Date</label>
                            <input type="date" name="join_date" class="form-control"
                                value="<?php echo e(optional($employee->join_date)->format('Y-m-d')); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Employee Full Name</label>
                            <input type="text" name="full_name" class="form-control"
                                value="<?php echo e($employee->full_name); ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Name With Initials</label>
                            <input type="text" name="name_with_initials" class="form-control"
                                value="<?php echo e($employee->name_with_initials); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">NIC</label>
                            <input type="text" name="nic" class="form-control" value="<?php echo e($employee->nic); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo e($employee->phone); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e($employee->email); ?>">
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:user-circle-outline"></iconify-icon>
                        Personal Information
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
                                value="<?php echo e(optional($employee->dob)->format('Y-m-d')); ?>">
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" min="0"
                                value="<?php echo e($employee->age); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control"
                                value="<?php echo e($employee->nationality); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Religion</label>
                            <input type="text" name="religion" class="form-control"
                                value="<?php echo e($employee->religion); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">District</label>
                            <input type="text" name="district" class="form-control"
                                value="<?php echo e($employee->district); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">GS Division</label>
                            <input type="text" name="gs_division" class="form-control"
                                value="<?php echo e($employee->gs_division); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Police Station</label>
                            <input type="text" name="police_station" class="form-control"
                                value="<?php echo e($employee->police_station); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-0">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"><?php echo e($employee->address); ?></textarea>
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:case-outline"></iconify-icon>
                        Job Information
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Service Number</label>
                            <input type="text" name="service_number" class="form-control"
                                value="<?php echo e($employee->service_number); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Rank</label>
                            <input type="text" name="rank" class="form-control"
                                value="<?php echo e($employee->rank); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Site / Location</label>
                            <input type="text" name="site_location" class="form-control"
                                value="<?php echo e($employee->site_location); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">VO</label>
                            <input type="text" name="vo" class="form-control"
                                value="<?php echo e($employee->vo); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-0">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control"
                                value="<?php echo e($employee->department); ?>">
                        </div>

                        <div class="col-md-4 mb-0">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control"
                                value="<?php echo e($employee->designation); ?>">
                        </div>

                        <div class="col-md-4 mb-0">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active" <?php echo e($employee->status == 'Active' ? 'selected' : ''); ?>>Active</option>
                                <option value="Inactive" <?php echo e($employee->status == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:book-bookmark-outline"></iconify-icon>
                        Education & Experience
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Education</label>
                            <input type="text" name="education" class="form-control"
                                value="<?php echo e($employee->education); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Other Qualification</label>
                            <input type="text" name="other_qualification" class="form-control"
                                value="<?php echo e($employee->other_qualification); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Previous Experience</label>
                            <input type="text" name="previous_experience" class="form-control"
                                value="<?php echo e($employee->previous_experience); ?>">
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">Period</label>
                            <input type="text" name="experience_period" class="form-control"
                                value="<?php echo e($employee->experience_period); ?>">
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:users-group-rounded-outline"></iconify-icon>
                        Close Relation / Emergency
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Close Relation</label>
                            <input type="text" name="close_relation" class="form-control"
                                value="<?php echo e($employee->close_relation); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Relationship</label>
                            <input type="text" name="relationship" class="form-control"
                                value="<?php echo e($employee->relationship); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">CR Contact</label>
                            <input type="text" name="cr_contact" class="form-control"
                                value="<?php echo e($employee->cr_contact); ?>">
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:wallet-money-outline"></iconify-icon>
                        Bank & Salary Information
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control"
                                value="<?php echo e($employee->bank_name); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="account_number" class="form-control"
                                value="<?php echo e($employee->account_number); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Branch</label>
                            <input type="text" name="branch" class="form-control"
                                value="<?php echo e($employee->branch); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" step="0.01" min="0" name="salary" class="form-control"
                                value="<?php echo e($employee->salary); ?>">
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:clipboard-check-outline"></iconify-icon>
                        Document / Compliance Checklist
                    </div>

                    <div class="checklist-box">
                        <div class="checklist-title">Mark available employee documents</div>

                        <div class="row">
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_m_um" value="1" <?php echo e($employee->doc_m_um ? 'checked' : ''); ?>><label class="form-check-label">M/UM</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_pension" value="1" <?php echo e($employee->doc_pension ? 'checked' : ''); ?>><label class="form-check-label">Pention</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_i_al" value="1" <?php echo e($employee->doc_i_al ? 'checked' : ''); ?>><label class="form-check-label">I.AL</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_2_ca" value="1" <?php echo e($employee->doc_2_ca ? 'checked' : ''); ?>><label class="form-check-label">2.CA</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_3_wcl" value="1" <?php echo e($employee->doc_3_wcl ? 'checked' : ''); ?>><label class="form-check-label">3.WCL</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_4_nic_c" value="1" <?php echo e($employee->doc_4_nic_c ? 'checked' : ''); ?>><label class="form-check-label">4.NIC C</label></div></div>

                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_5_bc" value="1" <?php echo e($employee->doc_5_bc ? 'checked' : ''); ?>><label class="form-check-label">5.BC</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_6_gnc" value="1" <?php echo e($employee->doc_6_gnc ? 'checked' : ''); ?>><label class="form-check-label">6.GNC</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_7_pr" value="1" <?php echo e($employee->doc_7_pr ? 'checked' : ''); ?>><label class="form-check-label">7.PR</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_8_ec" value="1" <?php echo e($employee->doc_8_ec ? 'checked' : ''); ?>><label class="form-check-label">8.EC</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_9_qc" value="1" <?php echo e($employee->doc_9_qc ? 'checked' : ''); ?>><label class="form-check-label">9.QC</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_10_chc" value="1" <?php echo e($employee->doc_10_chc ? 'checked' : ''); ?>><label class="form-check-label">10.CHC</label></div></div>

                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_11_po" value="1" <?php echo e($employee->doc_11_po ? 'checked' : ''); ?>><label class="form-check-label">11.PO</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_12_fp" value="1" <?php echo e($employee->doc_12_fp ? 'checked' : ''); ?>><label class="form-check-label">12.FP</label></div></div>
                            <div class="col-md-2 col-6"><div class="form-check"><input class="form-check-input" type="checkbox" name="doc_13_ba" value="1" <?php echo e($employee->doc_13_ba ? 'checked' : ''); ?>><label class="form-check-label">13.B/A</label></div></div>
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="form-section-title">
                        <iconify-icon icon="solar:notes-outline"></iconify-icon>
                        Remarks
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-0">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="3"><?php echo e($employee->remarks); ?></textarea>
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div>
                            <div class="form-section-title mb-1">
                                <iconify-icon icon="solar:widget-add-outline"></iconify-icon>
                                Custom / Additional Employee Details
                            </div>
                            <div class="section-subtitle">Use this area for employee-specific extra information.</div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSection('Father Details')">+ Father Details</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSection('Mother Details')">+ Mother Details</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSection('Wife Details')">+ Wife Details</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSection('Child Details')">+ Child Details</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSection('Emergency Contact')">+ Emergency Contact</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="addSection()">+ Custom Section</button>
                        </div>
                    </div>

                    <div id="dynamicSectionsWrapper"></div>
                </div>

                <div class="sticky-submit-bar">
                    <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let sectionIndex = 0;

        function createValueInput(sectionIdx, fieldIdx, type = 'text', value = '') {
            const fieldName = `dynamic_sections[${sectionIdx}][fields][${fieldIdx}][field_value]`;

            if (type === 'textarea') {
                return `<textarea name="${fieldName}" class="form-control" rows="2" placeholder="Enter value">${value ?? ''}</textarea>`;
            }

            return `<input type="${type}" name="${fieldName}" class="form-control" value="${value ?? ''}" placeholder="Enter value">`;
        }

        function addSection(defaultTitle = '', fields = []) {
            const wrapper = document.getElementById('dynamicSectionsWrapper');
            const currentIndex = sectionIndex;

            const html = `
                <div class="card mb-3 dynamic-section-card" data-section-index="${currentIndex}">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="w-75">
                            <label class="form-label mb-1">Section Title</label>
                            <input type="text" name="dynamic_sections[${currentIndex}][section_title]" class="form-control" value="${defaultTitle}" placeholder="Ex: Father Details">
                        </div>
                        <div class="ms-3 mt-4">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.dynamic-section-card').remove()">Remove Section</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="section-fields-wrapper"></div>
                        <button type="button" class="btn btn-outline-secondary btn-sm add-field-btn" onclick="addFieldRow(this, ${currentIndex})">+ Add Field</button>
                    </div>
                </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', html);

            const insertedCard = wrapper.lastElementChild;
            const addBtn = insertedCard.querySelector('.add-field-btn');

            if (fields.length) {
                fields.forEach(field => addFieldRow(addBtn, currentIndex, field));
            }

            sectionIndex++;
        }

        function addFieldRow(button, currentSectionIndex, data = {}) {
            const sectionCard = button.closest('.dynamic-section-card');
            const fieldsWrapper = sectionCard.querySelector('.section-fields-wrapper');
            const fieldIndex = fieldsWrapper.querySelectorAll('.field-row').length;
            const selectedType = data.input_type ?? 'text';

            const html = `
                <div class="row field-row border rounded p-2 mb-3">
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Field Label</label>
                        <input type="text" name="dynamic_sections[${currentSectionIndex}][fields][${fieldIndex}][field_label]" class="form-control" value="${data.field_label ?? ''}" placeholder="Ex: Father Name">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Input Type</label>
                        <select name="dynamic_sections[${currentSectionIndex}][fields][${fieldIndex}][input_type]" class="form-select" onchange="changeFieldInput(this, ${currentSectionIndex}, ${fieldIndex})">
                            <option value="text" ${selectedType === 'text' ? 'selected' : ''}>Text</option>
                            <option value="number" ${selectedType === 'number' ? 'selected' : ''}>Number</option>
                            <option value="date" ${selectedType === 'date' ? 'selected' : ''}>Date</option>
                            <option value="email" ${selectedType === 'email' ? 'selected' : ''}>Email</option>
                            <option value="textarea" ${selectedType === 'textarea' ? 'selected' : ''}>Textarea</option>
                        </select>
                    </div>
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Value</label>
                        <div class="field-value-wrapper">
                            ${createValueInput(currentSectionIndex, fieldIndex, selectedType, data.field_value ?? '')}
                        </div>
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="this.closest('.field-row').remove()">X</button>
                    </div>
                </div>
            `;

            fieldsWrapper.insertAdjacentHTML('beforeend', html);
        }

        function changeFieldInput(selectElement, sectionIdx, fieldIdx) {
            const fieldRow = selectElement.closest('.field-row');
            const wrapper = fieldRow.querySelector('.field-value-wrapper');
            wrapper.innerHTML = createValueInput(sectionIdx, fieldIdx, selectElement.value, '');
        }

        <?php
            $existingSections = $employee->detailSections
                ->map(function ($section) {
                    return [
                        'section_title' => $section->section_title,
                        'fields' => $section->fields
                            ->map(function ($field) {
                                return [
                                    'field_label' => $field->field_label,
                                    'input_type' => $field->input_type,
                                    'field_value' => $field->field_value,
                                ];
                            })
                            ->values()
                            ->toArray(),
                    ];
                })
                ->values()
                ->toArray();
        ?>

        const existingSections = <?php echo json_encode($existingSections, 15, 512) ?>;

        existingSections.forEach(section => {
            addSection(section.section_title, section.fields);
        });

        document.getElementById('editEmployeeForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json"
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    return {
                        status: response.status,
                        body: data
                    };
                })
                .then(result => {
                    let messageBox = document.getElementById('message');

                    if (result.status === 200 && result.body.success) {
                        messageBox.innerHTML = `<div class="alert alert-success">${result.body.message}</div>`;

                        setTimeout(() => {
                            window.location.href = result.body.redirect;
                        }, 1200);
                    } else {
                        let errors = result.body.errors ? Object.values(result.body.errors).flat().join('<br>') : 'Something went wrong.';
                        messageBox.innerHTML = `<div class="alert alert-danger">${errors}</div>`;
                    }
                })
                .catch(error => {
                    document.getElementById('message').innerHTML =
                        `<div class="alert alert-danger">Error: ${error}</div>`;
                });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Employee Edit'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\mis\resources\views/backend/pages/employees/edit.blade.php ENDPATH**/ ?>