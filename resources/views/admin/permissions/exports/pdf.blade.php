<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permissions Export Report - The Harmony Singers</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8fafc;
            color: #1f2937;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #3B82F6 !important;
            color: white !important;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
            color: white !important;

        .header h2 {
            margin: 8px 0 0 0;
            font-size: 18px;
            font-weight: 400;
            opacity: 0.9;
        }
            color: white !important;

        .no-filters {
            color: #6b7280;
            font-style: italic;
            font-size: 14px;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th {
            background: #3B82F6 !important;
            color: #ffffff !important;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #1E40AF;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tr:hover {
            background-color: #f3f4f6;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            color: #6b7280;
            font-size: 12px;
        }

        .footer p {
            margin: 0;
        }

            .header {
                background: #3B82F6 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

        }
            
            .header {
                background: #3B82F6 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

        }
        @media print {
            body {
                background-color: white !important;
                padding: 0;
            }
            
            .header {
                background: #3B82F6 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            th {
                background: #3B82F6 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>THE HARMONY SINGERS CHOIR</h1>
        <h2>Permissions Export Report</h2>
    </div>

    </div>

    <!-- Data Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Module</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $permissions)
                <tr>
                    <td>{{ $permissions->id ?? 'N/A' }}</td>
                    <td>{{ $permissions->name ?? 'N/A' }}</td>
                    <td>{{ Str::limit($permissions->description ?? 'N/A', 50) }}</td>
                    <td>{{ $permissions->module ?? 'N/A' }}</td>
                    <td>{{ $permissions->created_at->format('M j, Y g:i A') }}</td>
                    <td>{{ $permissions->updated_at->format('M j, Y g:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">
                        No records found matching the specified criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This report was generated automatically by The Harmony Singers Choir Management System.</p>
        <p>For questions or support, please contact the system administrator.</p>
    </div>
</body>

</html>