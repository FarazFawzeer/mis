@extends('layouts.vertical', ['subtitle' => 'Employee View'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Employees', 'subtitle' => 'Profile'])

    <style>
        .profile-main-card,
        .profile-section-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .profile-main-card .card-header,
        .profile-section-card .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 20px;
        }

        .profile-main-card .card-body,
        .profile-section-card .card-body {
            padding: 20px;
        }

        .profile-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .profile-topbar-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .employee-hero {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            padding: 20px;
            background: #f8f9fa;
            margin-bottom: 20px;
        }

        .employee-hero-name {
            font-size: 24px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 6px;
        }

        .employee-hero-sub {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 0;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pill.active {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }

        .status-pill.inactive {
            background: rgba(220, 53, 69, 0.12);
            color: #dc3545;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 16px;
        }

        .detail-box {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            padding: 14px 16px;
            height: 100%;
            background: #fff;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 14px;
            color: #212529;
            font-weight: 500;
            word-break: break-word;
        }

        .remarks-box {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            padding: 16px;
            background: #fff;
        }

        .dynamic-table th {
            background: #f8f9fa;
            font-size: 13px;
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
            vertical-align: middle;
        }

        .dynamic-table td {
            font-size: 14px;
            vertical-align: middle;
        }

        .input-type-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            background: rgba(13, 110, 253, 0.10);
            color: #0d6efd;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .empty-state {
            border: 1px dashed rgba(0, 0, 0, 0.12);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            color: #6c757d;
            background: #fafafa;
        }

        @media (max-width: 768px) {
            .employee-hero-name {
                font-size: 20px;
            }
        }
    </style>

    <div class="card profile-main-card mb-3">
        <div class="card-header">
            <div class="profile-topbar">
                <h5 class="card-title mb-0">Employee Profile</h5>

                <div class="profile-topbar-actions">
                    <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                        Edit Employee
                    </a>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-light btn-sm">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="employee-hero">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <div class="employee-hero-name">{{ $employee->full_name }}</div>
                        <p class="employee-hero-sub mb-1">
                            Employee No: <strong>{{ $employee->employee_no }}</strong>
                        </p>
                        <p class="employee-hero-sub mb-0">
                            {{ $employee->designation ?? 'No Designation' }}
                            @if($employee->department)
                                • {{ $employee->department }}
                            @endif
                        </p>
                    </div>

                    <div class="col-md-4 text-md-end">
                        @if($employee->status == 'Active')
                            <span class="status-pill active">Active</span>
                        @else
                            <span class="status-pill inactive">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="section-title">Main Employee Details</div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Employee Number</div>
                        <div class="detail-value">{{ $employee->employee_no ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value">{{ $employee->full_name ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">NIC</div>
                        <div class="detail-value">{{ $employee->nic ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value">{{ $employee->phone ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $employee->email ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Department</div>
                        <div class="detail-value">{{ $employee->department ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Designation</div>
                        <div class="detail-value">{{ $employee->designation ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            @if($employee->status == 'Active')
                                <span class="status-pill active">Active</span>
                            @else
                                <span class="status-pill inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="section-title">Remarks</div>
                <div class="remarks-box">
                    {{ $employee->remarks ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="section-title">Dynamic Sections</div>

    @forelse($employee->detailSections as $section)
        <div class="card profile-section-card mb-3">
            <div class="card-header">
                <h6 class="mb-0">{{ $section->section_title }}</h6>
            </div>

            <div class="card-body">
                @if($section->fields->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dynamic-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Label</th>
                                 
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($section->fields as $field)
                                    <tr>
                                        <td class="fw-semibold">{{ $field->field_label }}</td>
                                     
                                        <td>{{ $field->field_value ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        No details added in this section.
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="card profile-section-card">
            <div class="card-body">
                <div class="empty-state">
                    No dynamic sections added for this employee.
                </div>
            </div>
        </div>
    @endforelse
@endsection
