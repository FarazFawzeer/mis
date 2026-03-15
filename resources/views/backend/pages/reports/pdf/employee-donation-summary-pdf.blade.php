<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Donation Summary</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h2 { margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 7px; }
        th { background: #f3f3f3; text-align: left; }
    </style>
</head>
<body>
    <h2>Employee Donation Summary</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employee No</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Total Donations</th>
                <th>Total Amount</th>
                <th>Latest Donation Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->employee_no }}</td>
                    <td>{{ $row->full_name }}</td>
                    <td>{{ $row->department ?? '-' }}</td>
                    <td>{{ $row->total_donations }}</td>
                    <td>{{ number_format($row->total_amount, 2) }}</td>
                    <td>{{ $row->latest_donation_date ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
