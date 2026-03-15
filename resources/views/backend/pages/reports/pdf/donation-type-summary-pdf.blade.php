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
            @foreach($rows as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->donation_type }}</td>
                    <td>{{ $row->total_records }}</td>
                    <td>{{ number_format($row->total_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
