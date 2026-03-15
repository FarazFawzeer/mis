@extends('layouts.vertical', ['subtitle' => 'Donation Type Summary'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Reports', 'subtitle' => 'Donation Type Summary'])

    <div class="card mb-3" style="border:1px solid rgba(0,0,0,.08); border-radius:14px;">
        <div class="card-header"><h5 class="card-title mb-0">Filter Donation Type Summary</h5></div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.donation.type.summary') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            @foreach(['Pending','Approved','Completed','Cancelled'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.donation.type.summary.export.excel', request()->query()) }}" class="btn btn-success">Export Excel</a>
                        <a href="{{ route('admin.reports.donation.type.summary.export.pdf', request()->query()) }}" class="btn btn-danger" target="_blank">Export PDF</a>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.donation.type.summary') }}" class="btn btn-light">Reset</a>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="border:1px solid rgba(0,0,0,.08); border-radius:14px;">
        <div class="card-header"><h5 class="card-title mb-0">Donation Type Summary</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Donation Type</th>
                            <th>Total Records</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $key => $row)
                            <tr>
                                <td>{{ $rows->firstItem() + $key }}</td>
                                <td>{{ $row->donation_type }}</td>
                                <td>{{ $row->total_records }}</td>
                                <td>{{ number_format($row->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No records found.</td></tr>
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
