@extends('layouts.vertical', ['subtitle' => 'Dashboard'])

@section('content')
    @include('layouts.partials.page-title', ['title' => 'Dashboard', 'subtitle' => 'Overview'])

    <style>
        .dash-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
        }

        .dash-card .card-body {
            padding: 20px;
        }

        .dash-icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(13, 110, 253, 0.10);
        }

        .dash-icon-wrap iconify-icon {
            font-size: 30px;
            color: #0d6efd;
        }

        .dash-label {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .dash-value {
            font-size: 28px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0;
        }

        .section-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .section-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .section-card .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 20px;
        }

        .section-card .card-title {
            color: inherit;
        }

        .section-card .card-body {
            padding: 0;
        }

      .simple-table thead th {
    background: transparent !important;
    color: inherit !important;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.simple-table tbody td {
    font-size: 14px;
    vertical-align: middle;
    color: inherit;
}

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 88px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pill.active,
        .status-pill.completed {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }

        .status-pill.inactive,
        .status-pill.cancelled {
            background: rgba(220, 53, 69, 0.12);
            color: #dc3545;
        }

        .status-pill.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #b58105;
        }

        .status-pill.approved {
            background: rgba(13, 110, 253, 0.12);
            color: #0d6efd;
        }

        .table-empty {
            padding: 24px;
            text-align: center;
            color: #6c757d;
        }
    </style>

    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card dash-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="dash-label">Total Employees</p>
                            <h3 class="dash-value">{{ $totalEmployees }}</h3>
                        </div>
                        <div class="dash-icon-wrap">
                            <iconify-icon icon="solar:users-group-two-rounded-outline"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-6 col-xl-4">
            <div class="card dash-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="dash-label">Total Donations</p>
                            <h3 class="dash-value">{{ $totalDonations }}</h3>
                        </div>
                        <div class="dash-icon-wrap">
                            <iconify-icon icon="solar:hand-money-outline"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card dash-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="dash-label">Total Donation Amount</p>
                            <h3 class="dash-value">{{ number_format($totalDonationAmount ?? 0, 2) }}</h3>
                        </div>
                        <div class="dash-icon-wrap">
                            <iconify-icon icon="solar:wallet-money-outline"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-xl-5">
            <div class="card section-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Employees</h5>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-sm btn-light">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table simple-table mb-0">
                            <thead>
                                <tr>
                                    <th>Employee No</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEmployees as $employee)
                                    <tr>
                                        <td>{{ $employee->employee_no }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $employee->full_name }}</div>
                                            @if ($employee->designation)
                                                <small class="text-muted">{{ $employee->designation }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-pill {{ strtolower($employee->status) }}">
                                                {{ $employee->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="table-empty">No employee records found.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="card section-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Donations</h5>
                    <a href="{{ route('admin.donations.index') }}" class="btn btn-sm btn-light">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table simple-table mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Beneficiary</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentDonations as $donation)
                                    <tr>
                                        <td>{{ optional($donation->donation_date)->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $donation->beneficiary_name }}</div>
                                            @if ($donation->employee)
                                                <small class="text-muted">
                                                    {{ $donation->employee->employee_no }} -
                                                    {{ $donation->employee->full_name }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>{{ $donation->donation_type }}</td>
                                        <td>{{ $donation->amount !== null ? number_format($donation->amount, 2) : '-' }}
                                        </td>
                                        <td>
                                            <span class="status-pill {{ strtolower($donation->status) }}">
                                                {{ $donation->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="table-empty">No donation records found.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
