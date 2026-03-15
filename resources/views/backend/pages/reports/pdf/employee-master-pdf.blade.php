<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Master Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h2 { margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f3f3f3; text-align: left; }
    </style>
</head>
<body>
    <h2>Employee Master Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employee No</th>
                <th>Full Name</th>
                <th>NIC</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->employee_no }}</td>
                    <td>{{ $row->full_name }}</td>
                    <td>{{ $row->nic ?? '-' }}</td>
                    <td>{{ $row->phone ?? '-' }}</td>
                    <td>{{ $row->email ?? '-' }}</td>
                    <td>{{ $row->department ?? '-' }}</td>
                    <td>{{ $row->designation ?? '-' }}</td>
                    <td>{{ $row->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
