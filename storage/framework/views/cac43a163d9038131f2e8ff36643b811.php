

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Donations', 'subtitle' => 'Profile'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        .profile-main-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .profile-main-card .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 20px;
        }

        .profile-main-card .card-body {
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

        .donation-hero {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            padding: 20px;
            background: #f8f9fa;
            margin-bottom: 20px;
        }

        .donation-hero-name {
            font-size: 24px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 6px;
        }

        .donation-hero-sub {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 0;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 95px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pill.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #b58105;
        }

        .status-pill.approved {
            background: rgba(13, 110, 253, 0.12);
            color: #0d6efd;
        }

        .status-pill.completed {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }

        .status-pill.cancelled {
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
    </style>

    <div class="card profile-main-card mb-3">
        <div class="card-header">
            <div class="profile-topbar">
                <h5 class="card-title mb-0">Donation Profile</h5>

                <div class="profile-topbar-actions">
                    <a href="<?php echo e(route('admin.donations.receipt.pdf', $donation->id)); ?>" class="btn btn-danger btn-sm" target="_blank">
                        Receipt PDF
                    </a>
                    <a href="<?php echo e(route('admin.donations.edit', $donation->id)); ?>" class="btn btn-warning btn-sm">
                        Edit Donation
                    </a>
                    <a href="<?php echo e(route('admin.donations.index')); ?>" class="btn btn-light btn-sm">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="donation-hero">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <div class="donation-hero-name"><?php echo e($donation->beneficiary_name); ?></div>
                        <p class="donation-hero-sub mb-1">
                            Donation Type: <strong><?php echo e($donation->donation_type); ?></strong>
                        </p>
                        <p class="donation-hero-sub mb-0">
                            Date: <?php echo e(optional($donation->donation_date)->format('Y-m-d')); ?>

                        </p>
                    </div>

                    <div class="col-md-4 text-md-end">
                        <span class="status-pill <?php echo e(strtolower($donation->status)); ?>">
                            <?php echo e($donation->status); ?>

                        </span>
                    </div>
                </div>
            </div>

            <div class="section-title">Donation Details</div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Beneficiary Name</div>
                        <div class="detail-value"><?php echo e($donation->beneficiary_name ?? '-'); ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Donation Type</div>
                        <div class="detail-value"><?php echo e($donation->donation_type ?? '-'); ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Amount</div>
                        <div class="detail-value">
                            <?php echo e($donation->amount !== null ? number_format($donation->amount, 2) : '-'); ?>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Donation Date</div>
                        <div class="detail-value"><?php echo e(optional($donation->donation_date)->format('Y-m-d')); ?></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span class="status-pill <?php echo e(strtolower($donation->status)); ?>">
                                <?php echo e($donation->status); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-box">
                        <div class="detail-label">Linked Employee</div>
                        <div class="detail-value">
                            <?php if($donation->employee): ?>
                                <?php echo e($donation->employee->employee_no); ?> - <?php echo e($donation->employee->full_name); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="section-title">Description</div>
                <div class="remarks-box">
                    <?php echo e($donation->description ?? '-'); ?>

                </div>
            </div>

            <div class="mt-4">
                <div class="section-title">Remarks</div>
                <div class="remarks-box">
                    <?php echo e($donation->remarks ?? '-'); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Donation View'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\cmi\resources\views/backend/pages/donations/show.blade.php ENDPATH**/ ?>