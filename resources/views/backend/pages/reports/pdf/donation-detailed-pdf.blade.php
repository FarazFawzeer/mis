<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donation Detailed Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h2 { margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; vertical-align: top; }
        th { background: #f3f3f3; text-align: left; }
    </style>
</head>
<body>
    <h2>Donation Detailed Report</h2>
    <table>
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
            @foreach($rows as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ optional($row->donation_date)->format('Y-m-d') }}</td>
                    <td>{{ optional($row->employee)->employee_no ?? '-' }}</td>
                    <td>{{ optional($row->employee)->full_name ?? '-' }}</td>
                    <td>{{ $row->beneficiary_name }}</td>
                    <td>{{ $row->donation_type }}</td>
                    <td>{{ $row->amount !== null ? number_format($row->amount, 2) : '-' }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->description ?? '-' }}</td>
                    <td>{{ $row->remarks ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
