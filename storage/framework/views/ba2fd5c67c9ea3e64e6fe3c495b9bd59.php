

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Donations', 'subtitle' => 'View'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        .donation-search-card,
        .donation-table-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
        }

        .donation-search-card .card-header,
        .donation-table-card .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 20px;
        }

        .donation-search-card .card-body,
        .donation-table-card .card-body {
            padding: 20px;
        }

        .donation-table th {
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
            background-color: #f8f9fa;
            color: #495057;
            vertical-align: middle;
        }

        .donation-table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .status-badge {
            min-width: 88px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 999px;
        }

        .status-badge.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #b58105;
        }

        .status-badge.approved {
            background: rgba(13, 110, 253, 0.12);
            color: #0d6efd;
        }

        .status-badge.completed {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }

        .status-badge.cancelled {
            background: rgba(220, 53, 69, 0.12);
            color: #dc3545;
        }

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

        .action-icons a.view-icon iconify-icon {
            color: #0dcaf0;
        }

        .action-icons a.edit-icon iconify-icon {
            color: #ffc107;
        }

        .action-icons a.pdf-icon iconify-icon {
            color: #dc3545;
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
            transform: scale(1.15);
            transition: 0.2s;
        }

        .search-actions {
            display: flex;
            justify-content: end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .table-empty-state {
            padding: 28px 12px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
    </style>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card donation-search-card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">Search Donations</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.donations.index')); ?>">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" value="<?php echo e(request('search')); ?>"
                            placeholder="Beneficiary / Employee / Type">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Donation Type</label>
                        <input type="text" name="donation_type" class="form-control" value="<?php echo e(request('donation_type')); ?>"
                            placeholder="Donation Type">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="Pending" <?php echo e(request('status') == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="Approved" <?php echo e(request('status') == 'Approved' ? 'selected' : ''); ?>>Approved</option>
                            <option value="Completed" <?php echo e(request('status') == 'Completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="Cancelled" <?php echo e(request('status') == 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                    </div>
                </div>

                <div class="search-actions">
                    <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-light">Reset</a>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card donation-table-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title mb-0">Donation List</h5>
            <a href="<?php echo e(route('admin.donations.create')); ?>" class="btn btn-primary btn-sm">Create Donation</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover donation-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Beneficiary</th>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($donations->firstItem() + $key); ?></td>
                                <td><?php echo e($donation->beneficiary_name); ?></td>
                                <td>
                                    <?php if($donation->employee): ?>
                                        <?php echo e($donation->employee->employee_no); ?> - <?php echo e($donation->employee->full_name); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($donation->donation_type); ?></td>
                                <td><?php echo e($donation->amount !== null ? number_format($donation->amount, 2) : '-'); ?></td>
                                <td><?php echo e(optional($donation->donation_date)->format('Y-m-d')); ?></td>
                                <td class="text-center">
                                    <span class="status-badge <?php echo e(strtolower($donation->status)); ?>">
                                        <?php echo e($donation->status); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-icons">
                                        <a href="<?php echo e(route('admin.donations.show', $donation->id)); ?>" class="view-icon" title="View">
                                            <iconify-icon icon="solar:eye-outline"></iconify-icon>
                                        </a>

                                        <a href="<?php echo e(route('admin.donations.edit', $donation->id)); ?>" class="edit-icon" title="Edit">
                                            <iconify-icon icon="solar:pen-2-outline"></iconify-icon>
                                        </a>

                                        <a href="<?php echo e(route('admin.donations.receipt.pdf', $donation->id)); ?>" class="pdf-icon" title="Receipt PDF" target="_blank">
                                            <iconify-icon icon="solar:file-download-outline"></iconify-icon>
                                        </a>

                                        <form action="<?php echo e(route('admin.donations.destroy', $donation->id)); ?>" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this donation?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="delete-btn" title="Delete">
                                                <iconify-icon icon="solar:trash-bin-minimalistic-outline"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">
                                    <div class="table-empty-state">No donation records found.</div>
                                </td>
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

<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Donations View'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\cmi\resources\views/backend/pages/donations/index.blade.php ENDPATH**/ ?>