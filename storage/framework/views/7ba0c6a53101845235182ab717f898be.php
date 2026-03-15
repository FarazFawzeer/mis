

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Reports', 'subtitle' => 'Donation Type Summary'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="card mb-3" style="border:1px solid rgba(0,0,0,.08); border-radius:14px;">
        <div class="card-header"><h5 class="card-title mb-0">Filter Donation Type Summary</h5></div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.reports.donation.type.summary')); ?>">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <?php $__currentLoopData = ['Pending','Approved','Completed','Cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>><?php echo e($status); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('admin.reports.donation.type.summary.export.excel', request()->query())); ?>" class="btn btn-success">Export Excel</a>
                        <a href="<?php echo e(route('admin.reports.donation.type.summary.export.pdf', request()->query())); ?>" class="btn btn-danger" target="_blank">Export PDF</a>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('admin.reports.donation.type.summary')); ?>" class="btn btn-light">Reset</a>
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
                        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($rows->firstItem() + $key); ?></td>
                                <td><?php echo e($row->donation_type); ?></td>
                                <td><?php echo e($row->total_records); ?></td>
                                <td><?php echo e(number_format($row->total_amount, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($rows->hasPages()): ?>
                <div class="mt-3 d-flex justify-content-end">
                    <?php echo e($rows->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Donation Type Summary'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\cmi\resources\views/backend/pages/reports/donation-type-summary.blade.php ENDPATH**/ ?>