<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donation Type Summary</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h2 { margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 7px; }
        th { background: #f3f3f3; text-align: left; }
    </style>
</head>
<body>
    <h2>Donation Type Summary</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Donation Type</th>
                <th>Total Records</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key + 1); ?></td>
                    <td><?php echo e($row->donation_type); ?></td>
                    <td><?php echo e($row->total_records); ?></td>
                    <td><?php echo e(number_format($row->total_amount, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH F:\Personal Projects\Infotech\cmi\resources\views/backend/pages/reports/pdf/donation-type-summary-pdf.blade.php ENDPATH**/ ?>