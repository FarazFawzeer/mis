@extends('layouts.vertical', ['subtitle' => 'Employee Master Report'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Reports', 'subtitle' => 'Employee Master'])

    <div class="card mb-3" style="border:1px solid rgba(0,0,0,.08); border-radius:14px;">
        <div class="card-header"><h5 class="card-title mb-0">Filter Employee Master Report</h5></div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.employee.master') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Employee No / Name / NIC / Phone / Email">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="{{ request('department') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            @foreach(['Active','Inactive'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.employee.master.export.excel', request()->query()) }}" class="btn btn-success">Export Excel</a>
                        <a href="{{ route('admin.reports.employee.master.export.pdf', request()->query()) }}" class="btn btn-danger" target="_blank">Export PDF</a>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.employee.master') }}" class="btn btn-light">Reset</a>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="border:1px solid rgba(0,0,0,.08); border-radius:14px;">
        <div class="card-header"><h5 class="card-title mb-0">Employee Master Report</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee No</th>
                            <th>Full Name</th>
                            <th>NIC</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $key => $row)
                            <tr>
                                <td>{{ $rows->firstItem() + $key }}</td>
                                <td>{{ $row->employee_no }}</td>
                                <td>{{ $row->full_name }}</td>
                                <td>{{ $row->nic ?? '-' }}</td>
                                <td>{{ $row->phone ?? '-' }}</td>
                                <td>{{ $row->email ?? '-' }}</td>
                                <td>{{ $row->department ?? '-' }}</td>
                                <td>{{ $row->designation ?? '-' }}</td>
                                <td>{{ $row->status }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($rows->hasPages())
                <div class="mt-3 d-flex justify-content-end">
                    {{ $rows->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
