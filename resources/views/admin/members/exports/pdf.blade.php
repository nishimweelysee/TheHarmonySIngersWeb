<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Export - The Harmony Singers</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        font-size: 10px;
        line-height: 1.4;
        color: #333;
        margin: 0;
        padding: 20px;
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
        color: white !important;
        font-size: 28px;
        margin: 0 0 10px 0;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .header .subtitle {
        color: white !important;
        font-size: 18px;
        margin: 0;
        opacity: 0.9;
    }


    .table-container {
        overflow-x: auto;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background-color: white;
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
    }

    td {
        padding: 6px;
        border: 1px solid #E5E7EB;
        font-size: 8px;
        vertical-align: top;
    }

    tr:nth-child(even) {
        background-color: #F9FAFB;
    }

    tr:hover {
        background-color: #F3F4F6;
    }

    .status-badge {
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 7px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-active {
        background-color: #D1FAE5;
        color: #065F46;
    }

    .status-inactive {
        background-color: #FEE2E2;
        color: #991B1B;
    }

    .status-pending {
        background-color: #FEF3C7;
        color: #92400E;
    }

    .type-badge {
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 7px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .type-regular {
        background-color: #EFF6FF;
        color: #1E40AF;
    }

    .type-senior {
        background-color: #F3E8FF;
        color: #7C3AED;
    }

    .type-junior {
        background-color: #ECFDF5;
        color: #059669;
    }

    .voice-part {
        font-weight: bold;
        color: #7C3AED;
    }

    .footer {
        margin-top: 30px;
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
        color: #6B7280;
        font-size: 8px;
    }

    .page-break {
        page-break-before: always;
    }

    .summary-stats {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
        padding: 15px;
        background-color: #F0F9FF;
        border-radius: 8px;
        border: 1px solid #BAE6FD;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 18px;
        font-weight: bold;
        color: #0369A1;
        display: block;
    }

    .stat-label {
        font-size: 9px;
        color: #0C4A6E;
        margin-top: 2px;
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
    <div class="header">
        <h1>THE HARMONY SINGERS CHOIR</h1>
        <p class="subtitle">Members Directory Export</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 12%;">Name</th>
                    <th style="width: 15%;">Email</th>
                    <th style="width: 10%;">Phone</th>
                    <th style="width: 8%;">Type</th>
                    <th style="width: 8%;">Voice Part</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 10%;">Joined Date</th>
                    <th style="width: 10%;">Date of Birth</th>
                    <th style="width: 14%;">Emergency Contact</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>
                        <strong>{{ $member->first_name }} {{ $member->last_name }}</strong>
                    </td>
                    <td>{{ $member->email ?? 'N/A' }}</td>
                    <td>{{ $member->phone ?? 'N/A' }}</td>
                    <td>
                        @if($member->type)
                        <span class="type-badge type-{{ $member->type }}">
                            {{ ucfirst($member->type) }}
                        </span>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        @if($member->voice_part)
                        <span class="voice-part">{{ ucfirst($member->voice_part) }}</span>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        @if($member->status)
                        <span class="status-badge status-{{ $member->status }}">
                            {{ ucfirst($member->status) }}
                        </span>
                        @else
                        N/A
                        @endif
                    </td>
                    <td>{{ $member->joined_date ? $member->joined_date->format('M j, Y') : 'N/A' }}</td>
                    <td>{{ $member->date_of_birth ? $member->date_of_birth->format('M j, Y') : 'N/A' }}</td>
                    <td>
                        @if($member->emergency_contact)
                        {{ $member->emergency_contact }}
                        @if($member->emergency_phone)
                        <br><small>({{ $member->emergency_phone }})</small>
                        @endif
                        @else
                        N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>This report was generated on {{ $exportDate->format('F j, Y \a\t g:i A') }} by The Harmony Singers Management
            System</p>
        <p>For questions about this report, please contact the choir administration.</p>
    </div>
</body>

</html>