@extends('layouts.vertical', ['subtitle' => 'Employee Edit'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Employees', 'subtitle' => 'Edit'])

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Employee</h5>
        </div>

        <div class="card-body">
            <div id="message"></div>

            <form id="editEmployeeForm" action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Main Employee Details</h5>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ $employee->full_name }}"
                            required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">NIC</label>
                        <input type="text" name="nic" class="form-control" value="{{ $employee->nic }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="{{ $employee->department }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control" value="{{ $employee->designation }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="Active" {{ $employee->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $employee->status == 'Inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3">{{ $employee->remarks }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Dynamic Employee Details</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary btn-sm"
                            onclick="addSection('Father Details')">+ Father Details</button>
                        <button type="button" class="btn btn-outline-primary btn-sm"
                            onclick="addSection('Mother Details')">+ Mother Details</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSection('Wife Details')">+
                            Wife Details</button>
                        <button type="button" class="btn btn-outline-primary btn-sm"
                            onclick="addSection('Child Details')">+ Child Details</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addSection()">+ Custom
                            Section</button>
                    </div>
                </div>

                <div id="dynamicSectionsWrapper"></div>

                <div class="d-flex justify-content-end mt-4">
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
                    <div class="card-header d-flex justify-content-between align-items-center">
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

        @php
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
        @endphp

        const existingSections = @json($existingSections);

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
                        let errors = result.body.errors ? Object.values(result.body.errors).flat().join(
                            '<br>') : 'Something went wrong.';
                        messageBox.innerHTML = `<div class="alert alert-danger">${errors}</div>`;
                    }
                })
                .catch(error => {
                    document.getElementById('message').innerHTML =
                        `<div class="alert alert-danger">Error: ${error}</div>`;
                });
        });
    </script>
@endsection
