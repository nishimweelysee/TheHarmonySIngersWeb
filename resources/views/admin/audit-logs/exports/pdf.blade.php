<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs Export Report - The Harmony Singers</title>
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
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header h2 {
            margin: 8px 0 0 0;
            font-size: 18px;
            font-weight: 400;
            color: white !important;
            opacity: 0.9;
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
            font-size: 11px;
        }

        th {
            background: #3B82F6 !important;
            color: #ffffff !important;
            padding: 10px 6px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #1E40AF;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        td {
            padding: 8px 6px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tr:hover {
            background-color: #f3f4f6;
        }

        .event-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .event-created {
            background-color: #dcfce7;
            color: #166534;
        }

        .event-updated {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .event-deleted {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .event-login {
            background-color: #fef3c7;
            color: #92400e;
        }

        .event-logout {
            background-color: #f3e8ff;
            color: #7c3aed;
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

        @media print {
            body {
                background-color: white;
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
        <h2>Audit Logs Export Report</h2>
    </div>

    <!-- Data Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event</th>
                    <th>User</th>
                    <th>User Email</th>
                    <th>Model Type</th>
                    <th>Model ID</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auditLogs as $auditLog)
                <tr>
                    <td>{{ $auditLog->id ?? 'N/A' }}</td>
                    <td>
                        @if($auditLog->event)
                        <span class="event-badge event-{{ strtolower($auditLog->event) }}">
                            {{ ucfirst($auditLog->event) }}
                        </span>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        @if($auditLog->user)
                        {{ $auditLog->user->name }}
                        @else
                        System
                        @endif
                    </td>
                    <td>
                        @if($auditLog->user)
                        {{ $auditLog->user->email }}
                        @else
                        Automated Action
                        @endif
                    </td>
                    <td>
                        @if($auditLog->auditable_type)
                        {{ class_basename($auditLog->auditable_type) }}
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $auditLog->auditable_id ?? 'N/A' }}</td>
                    <td>{{ Str::limit($auditLog->description ?? 'N/A', 40) }}</td>
                    <td>{{ $auditLog->ip_address ?? 'N/A' }}</td>
                    <td>{{ $auditLog->created_at->format('M j, Y H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px; color: #6b7280;">
                        No audit logs found matching the specified criteria.
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