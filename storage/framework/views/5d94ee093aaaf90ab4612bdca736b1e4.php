<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donation Receipt</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .page {
            padding: 28px 32px;
        }

        .receipt-wrapper {
            border: 1px solid #d9d9d9;
            border-radius: 12px;
            overflow: hidden;
        }

        .receipt-header {
            background: #f4f6f9;
            padding: 20px 24px;
            border-bottom: 1px solid #d9d9d9;
        }

        .company-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 4px;
            color: #111;
        }

        .company-subtitle {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        .receipt-title-row {
            width: 100%;
            margin-top: 16px;
        }

        .receipt-title-left {
            float: left;
            width: 60%;
        }

        .receipt-title-right {
            float: right;
            width: 40%;
            text-align: right;
        }

        .receipt-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            color: #111;
        }

        .receipt-meta {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
        }

        .clear {
            clear: both;
        }

        .receipt-body {
            padding: 24px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #444;
            margin: 0 0 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #ececec;
            vertical-align: top;
        }

        .label {
            width: 32%;
            color: #666;
            font-weight: 700;
        }

        .value {
            color: #111;
        }

        .amount-box {
            margin-top: 18px;
            border: 1px solid #dcdcdc;
            border-radius: 10px;
            overflow: hidden;
        }

        .amount-box-header {
            background: #f8f9fb;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 700;
            color: #555;
            border-bottom: 1px solid #dcdcdc;
        }

        .amount-box-body {
            padding: 16px 14px;
            text-align: right;
        }

        .amount-value {
            font-size: 26px;
            font-weight: 700;
            color: #111;
        }

        .notes-box {
            margin-top: 20px;
            border: 1px solid #ececec;
            border-radius: 10px;
            padding: 14px;
            background: #fafafa;
        }

        .footer {
            margin-top: 32px;
        }

        .signature-row {
            width: 100%;
            margin-top: 36px;
        }

        .signature-box {
            float: left;
            width: 45%;
            text-align: center;
        }

        .signature-line {
            margin: 36px auto 8px;
            width: 180px;
            border-top: 1px solid #666;
        }

        .footer-note {
            margin-top: 24px;
            font-size: 11px;
            color: #777;
            text-align: center;
        }

        .status-pill {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            color: #111;
            border: 1px solid #d9d9d9;
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="receipt-wrapper">
            <div class="receipt-header">
                <p class="company-title">Donation Receipt</p>
                <p class="company-subtitle">Employee Donation Management System</p>

                <div class="receipt-title-row">
                    <div class="receipt-title-left">
                        <p class="receipt-title">Receipt Voucher</p>
                        <div class="receipt-meta">
                            Donation Date: <?php echo e(optional($donation->donation_date)->format('Y-m-d')); ?>

                        </div>
                    </div>

                    <div class="receipt-title-right">
                        <div class="receipt-meta"><strong>Receipt No:</strong> <?php echo e($receiptNo); ?></div>
                        <div class="receipt-meta"><strong>Generated On:</strong> <?php echo e(now()->format('Y-m-d')); ?></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="receipt-body">
                <p class="section-title">Donation Information</p>

                <table class="info-table">
                    <tr>
                        <td class="label">Beneficiary Name</td>
                        <td class="value"><?php echo e($donation->beneficiary_name ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Donation Type</td>
                        <td class="value"><?php echo e($donation->donation_type ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Donation Date</td>
                        <td class="value"><?php echo e(optional($donation->donation_date)->format('Y-m-d')); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Linked Employee</td>
                        <td class="value">
                            <?php if($donation->employee): ?>
                                <?php echo e($donation->employee->employee_no); ?> - <?php echo e($donation->employee->full_name); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Status</td>
                        <td class="value">
                            <span class="status-pill"><?php echo e($donation->status); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Description</td>
                        <td class="value"><?php echo e($donation->description ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Remarks</td>
                        <td class="value"><?php echo e($donation->remarks ?? '-'); ?></td>
                    </tr>
                </table>

                <div class="amount-box">
                    <div class="amount-box-header">Donation Amount</div>
                    <div class="amount-box-body">
                        <div class="amount-value">
                            <?php echo e($donation->amount !== null ? number_format($donation->amount, 2) : '0.00'); ?>

                        </div>
                    </div>
                </div>

                <div class="notes-box">
                    This receipt is generated for internal record and acknowledgement purposes of the donation entry.
                </div>

                <div class="footer">
                    <div class="signature-row">
                        <div class="signature-box">
                            <div class="signature-line"></div>
                            Prepared By
                        </div>

                        <div class="signature-box" style="float:right;">
                            <div class="signature-line"></div>
                            Authorized Signature
                        </div>
                    </div>
                    <div class="clear"></div>

                    <div class="footer-note">
                        System Generated Receipt
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH F:\Personal Projects\Infotech\cmi\resources\views/backend/pages/donations/receipt-pdf.blade.php ENDPATH**/ ?>