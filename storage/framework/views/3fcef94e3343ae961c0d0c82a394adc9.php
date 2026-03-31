

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Employees', 'subtitle' => 'View'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

        @media (max-width: 768px) {
            .employee-table th,
            .employee-table td {
                white-space: nowrap;
            }
        }
    </style>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card employee-search-card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">Search Employees</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.employees.index')); ?>">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" value="<?php echo e(request('search')); ?>"
                            placeholder="Employee No / Name / NIC / Phone / Service No">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="<?php echo e(request('department')); ?>"
                            placeholder="Department">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control" value="<?php echo e(request('district')); ?>"
                            placeholder="District">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="Active" <?php echo e(request('status') == 'Active' ? 'selected' : ''); ?>>Active</option>
                            <option value="Inactive" <?php echo e(request('status') == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="search-actions">
                    <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-light">Reset</a>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card employee-table-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title mb-0">Employee List</h5>
            <a href="<?php echo e(route('admin.employees.create')); ?>" class="btn btn-primary btn-sm">
                Create Employee
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover employee-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">#</th>
                            <th style="min-width: 120px;">Employee No</th>
                            <th style="min-width: 220px;">Employee</th>
                            <th style="min-width: 130px;">Service No</th>
                            <th style="min-width: 130px;">Rank</th>
                            <th style="min-width: 140px;">Phone</th>
                            <th style="min-width: 140px;">District</th>
                            <th style="min-width: 160px;">VO</th>
                            <th style="width: 120px;" class="text-center">Status</th>
                            <th style="min-width: 180px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($employees->firstItem() + $key); ?></td>

                                <td>
                                    <span class="fw-semibold"><?php echo e($employee->employee_no); ?></span>
                                </td>

                                <td>
                                    <div class="employee-name"><?php echo e($employee->full_name); ?></div>
                                    <?php if($employee->name_with_initials): ?>
                                        <div class="employee-sub"><?php echo e($employee->name_with_initials); ?></div>
                                    <?php elseif($employee->designation): ?>
                                        <div class="employee-sub"><?php echo e($employee->designation); ?></div>
                                    <?php endif; ?>
                                </td>

                                <td><?php echo e($employee->service_number ?? '-'); ?></td>
                                <td><?php echo e($employee->rank ?? '-'); ?></td>
                                <td><?php echo e($employee->phone ?? '-'); ?></td>
                                <td><?php echo e($employee->district ?? '-'); ?></td>
                                <td><?php echo e($employee->vo ?? '-'); ?></td>

                                <td class="text-center">
                                    <?php if($employee->status == 'Active'): ?>
                                        <span class="status-badge active">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="action-icons">
                                        <a href="<?php echo e(route('admin.employees.show', $employee->id)); ?>" title="View">
                                            <iconify-icon icon="solar:eye-outline"></iconify-icon>
                                        </a>

                                        <a href="<?php echo e(route('admin.employees.edit', $employee->id)); ?>" title="Edit">
                                            <iconify-icon icon="solar:pen-2-outline"></iconify-icon>
                                        </a>

                                        <form action="<?php echo e(route('admin.employees.destroy', $employee->id)); ?>"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this employee?')">
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
                                <td colspan="10">
                                    <div class="table-empty-state">
                                        No employee records found.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($employees->hasPages()): ?>
                <div class="mt-3 d-flex justify-content-end">
                    <?php echo e($employees->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Employees View'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\mis\resources\views/backend/pages/employees/index.blade.php ENDPATH**/ ?>