@extends('layouts.vertical', ['subtitle' => 'Employees View'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Employees', 'subtitle' => 'View'])

 <style>

    .action-icons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 14px;
}

.action-icons a {
    font-size: 20px;
    text-decoration: none;
}

.action-icons a:nth-child(1) iconify-icon {
    color: #0dcaf0;
}

.action-icons a:nth-child(2) iconify-icon {
    color: #ffc107;
}

.delete-btn {
    border: none;
    background: none;
    padding: 0;
    font-size: 20px;
}

.delete-btn iconify-icon {
    color: #dc3545;
}

.action-icons a:hover iconify-icon,
.delete-btn:hover iconify-icon {
    transform: scale(1.2);
    transition: 0.2s;
}

    .employee-search-card,
    .employee-table-card {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 14px;
    }

    .employee-search-card .card-header,
    .employee-table-card .card-header {
        background: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        padding: 16px 20px;
    }

    .employee-search-card .card-body,
    .employee-table-card .card-body {
        padding: 20px;
    }

    .employee-table th {
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
        background-color: #f8f9fa;
        color: #495057;
        vertical-align: middle;
    }

    .employee-table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .employee-table .employee-name {
        font-weight: 600;
        color: #212529;
    }

    .employee-table .employee-sub {
        font-size: 12px;
        color: #6c757d;
    }

    .status-badge {
        min-width: 78px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 999px;
    }

    .status-badge.active {
        background: rgba(25, 135, 84, 0.12);
        color: #198754;
    }

    .status-badge.inactive {
        background: rgba(220, 53, 69, 0.12);
        color: #dc3545;
    }

    .action-btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        align-items: center;
    }

    .action-btn-group .btn,
    .action-btn-group form .btn {
        min-width: 68px;
    }

    .action-btn-group form {
        margin: 0;
    }

    .table-empty-state {
        padding: 28px 12px;
        text-align: center;
        color: #6c757d;
        font-size: 14px;
    }

    .search-actions {
        display: flex;
        justify-content: end;
        gap: 10px;
        flex-wrap: wrap;
    }

    @media (max-width: 1200px) {
        .action-btn-group {
            flex-direction: column;
            align-items: stretch;
        }

        .action-btn-group .btn,
        .action-btn-group form,
        .action-btn-group form .btn {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .employee-table th,
        .employee-table td {
            white-space: nowrap;
        }
    }
</style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card employee-search-card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">Search Employees</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.employees.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="Employee No / Name / NIC / Phone">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="{{ request('department') }}"
                            placeholder="Department">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="search-actions">
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-light">Reset</a>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card employee-table-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title mb-0">Employee List</h5>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-sm">
                Create Employee
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover employee-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">#</th>
                            <th style="min-width: 130px;">Employee No</th>
                            <th style="min-width: 220px;">Employee</th>
                            <th style="min-width: 150px;">NIC</th>
                            <th style="min-width: 140px;">Phone</th>
                            <th style="min-width: 150px;">Department</th>
                            <th style="width: 120px;" class="text-center">Status</th>
                            <th style="min-width: 220px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $key => $employee)
                            <tr>
                                <td>{{ $employees->firstItem() + $key }}</td>

                                <td>
                                    <span class="fw-semibold">{{ $employee->employee_no }}</span>
                                </td>

                                <td>
                                    <div class="employee-name">{{ $employee->full_name }}</div>
                                  
                                </td>

                                <td>{{ $employee->nic ?? '-' }}</td>
                                <td>{{ $employee->phone ?? '-' }}</td>
                                <td>{{ $employee->department ?? '-' }}</td>

                                <td class="text-center">
                                    @if($employee->status == 'Active')
                                        <span class="status-badge active">Active</span>
                                    @else
                                        <span class="status-badge inactive">Inactive</span>
                                    @endif
                                </td>

                           <td class="text-center">
    <div class="action-icons">

        <a href="{{ route('admin.employees.show', $employee->id) }}" title="View">
            <iconify-icon icon="solar:eye-outline"></iconify-icon>
        </a>

        <a href="{{ route('admin.employees.edit', $employee->id) }}" title="Edit">
            <iconify-icon icon="solar:pen-2-outline"></iconify-icon>
        </a>

        <form action="{{ route('admin.employees.destroy', $employee->id) }}"
            method="POST"
            onsubmit="return confirm('Are you sure you want to delete this employee?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="delete-btn" title="Delete">
                <iconify-icon icon="solar:trash-bin-minimalistic-outline"></iconify-icon>
            </button>

        </form>

    </div>
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="table-empty-state">
                                        No employee records found.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($employees->hasPages())
                <div class="mt-3 d-flex justify-content-end">
                    {{ $employees->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
