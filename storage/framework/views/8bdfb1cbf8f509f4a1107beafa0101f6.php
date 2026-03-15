

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Dashboard', 'subtitle' => 'Overview'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                            <h3 class="dash-value"><?php echo e($totalEmployees); ?></h3>
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
                            <h3 class="dash-value"><?php echo e($totalDonations); ?></h3>
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
                            <h3 class="dash-value"><?php echo e(number_format($totalDonationAmount ?? 0, 2)); ?></h3>
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
                    <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-sm btn-light">View All</a>
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
                                <?php $__empty_1 = true; $__currentLoopData = $recentEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($employee->employee_no); ?></td>
                                        <td>
                                            <div class="fw-semibold"><?php echo e($employee->full_name); ?></div>
                                            <?php if($employee->designation): ?>
                                                <small class="text-muted"><?php echo e($employee->designation); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-pill <?php echo e(strtolower($employee->status)); ?>">
                                                <?php echo e($employee->status); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3">
                                            <div class="table-empty">No employee records found.</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                    <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-sm btn-light">View All</a>
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
                                <?php $__empty_1 = true; $__currentLoopData = $recentDonations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(optional($donation->donation_date)->format('Y-m-d')); ?></td>
                                        <td>
                                            <div class="fw-semibold"><?php echo e($donation->beneficiary_name); ?></div>
                                            <?php if($donation->employee): ?>
                                                <small class="text-muted">
                                                    <?php echo e($donation->employee->employee_no); ?> -
                                                    <?php echo e($donation->employee->full_name); ?>

                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($donation->donation_type); ?></td>
                                        <td><?php echo e($donation->amount !== null ? number_format($donation->amount, 2) : '-'); ?>

                                        </td>
                                        <td>
                                            <span class="status-pill <?php echo e(strtolower($donation->status)); ?>">
                                                <?php echo e($donation->status); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5">
                                            <div class="table-empty">No donation records found.</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\mis\resources\views/dashboard.blade.php ENDPATH**/ ?>