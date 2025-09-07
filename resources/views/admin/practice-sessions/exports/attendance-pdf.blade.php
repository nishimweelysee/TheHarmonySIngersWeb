<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - The Harmony Singers</title>
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

        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-present {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-absent {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-late {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-excused {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .status-not-recorded {
            background-color: #f3f4f6;
            color: #6b7280;
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
        <h2>Practice Session Attendance Report</h2>
    </div>


    <!-- Attendance Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Voice Part</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th>Notes</th>
                    <th>Arrival Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allMembers as $member)
                @php
                $attendance = $practiceSession->attendances->where('member_id', $member->id)->first();
                $status = $attendance ? $attendance->status : 'not_recorded';
                @endphp
                <tr>
                    <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?? 'N/A' }}</td>
                    <td>{{ ucfirst($member->voice_part ?? 'N/A') }}</td>
                    <td>
                        <span class="status-badge status-{{ $status }}">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </td>
                    <td>{{ $attendance ? $attendance->reason : '' }}</td>
                    <td>{{ $attendance ? $attendance->notes : '' }}</td>
                    <td>{{ $attendance && $attendance->arrival_time ? $attendance->arrival_time->format('g:i A') : '' }}
                    </td>
                </tr>
                @endforeach
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