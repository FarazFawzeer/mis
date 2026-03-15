

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Reports', 'subtitle' => 'Donation Detailed'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        .report-card { border: 1px solid rgba(0,0,0,.08); border-radius: 14px; }
        .summary-box { border: 1px solid rgba(0,0,0,.08); border-radius: 12px; padding: 16px; background: #fff; height: 100%; }
        .summary-label { font-size: 12px; color: #6c757d; text-transform: uppercase; font-weight: 600; margin-bottom: 8px; }
        .summary-value { font-size: 22px; font-weight: 700; color: #212529; }
        .status-pill { padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; display: inline-block; }
        .status-pill.Pending { background: rgba(255,193,7,.15); color: #b58105; }
        .status-pill.Approved { background: rgba(13,110,253,.12); color: #0d6efd; }
        .status-pill.Completed { background: rgba(25,135,84,.12); color: #198754; }
        .status-pill.Cancelled { background: rgba(220,53,69,.12); color: #dc3545; }
    </style>

    <div class="card report-card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">Filter Donation Detailed Report</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.reports.donation.detailed')); ?>">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Beneficiary / Employee / Remarks">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Employee</label>
                        <select name="employee_id" class="form-select">
                            <option value="">All Employees</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php echo e(request('employee_id') == $employee->id ? 'selected' : ''); ?>>
                                    <?php echo e($employee->employee_no); ?> - <?php echo e($employee->full_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Donation Type</label>
                        <input type="text" class="form-control" name="donation_type" value="<?php echo e(request('donation_type')); ?>">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <?php $__currentLoopData = ['Pending','Approved','Completed','Cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>><?php echo e($status); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">From</label>
                        <input type="date" class="form-control" name="date_from" value="<?php echo e(request('date_from')); ?>">
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">To</label>
                        <input type="date" class="form-control" name="date_to" value="<?php echo e(request('date_to')); ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('admin.reports.donation.detailed.export.excel', request()->query())); ?>" class="btn btn-success">Export Excel</a>
                        <a href="<?php echo e(route('admin.reports.donation.detailed.export.pdf', request()->query())); ?>" class="btn btn-danger" target="_blank">Export PDF</a>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('admin.reports.donation.detailed')); ?>" class="btn btn-light">Reset</a>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="summary-box">
                <div class="summary-label">Total Records</div>
                <div class="summary-value"><?php echo e($summary['total_records']); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-box">
                <div class="summary-label">Total Amount</div>
                <div class="summary-value"><?php echo e(number_format($summary['total_amount'], 2)); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-box">
                <div class="summary-label">Completed Donations</div>
                <div class="summary-value"><?php echo e($summary['completed_count']); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-box">
                <div class="summary-label">Pending Donations</div>
                <div class="summary-value"><?php echo e($summary['pending_count']); ?></div>
            </div>
        </div>
    </div>

    <div class="card report-card">
        <div class="card-header">
            <h5 class="card-title mb-0">Donation Detailed Report</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Employee No</th>
                            <th>Employee Name</th>
                            <th>Beneficiary</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($donations->firstItem() + $key); ?></td>
                                <td><?php echo e(optional($row->donation_date)->format('Y-m-d')); ?></td>
                                <td><?php echo e(optional($row->employee)->employee_no ?? '-'); ?></td>
                                <td><?php echo e(optional($row->employee)->full_name ?? '-'); ?></td>
                                <td><?php echo e($row->beneficiary_name); ?></td>
                                <td><?php echo e($row->donation_type); ?></td>
                                <td><?php echo e($row->amount !== null ? number_format($row->amount, 2) : '-'); ?></td>
                                <td><span class="status-pill <?php echo e($row->status); ?>"><?php echo e($row->status); ?></span></td>
                                <td><?php echo e($row->description ?? '-'); ?></td>
                                <td><?php echo e($row->remarks ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($donations->hasPages()): ?>
                <div class="mt-3 d-flex justify-content-end">
                    <?php echo e($donations->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Donation Detailed Report'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\cmi\resources\views/backend/pages/reports/donation-detailed.blade.php ENDPATH**/ ?>