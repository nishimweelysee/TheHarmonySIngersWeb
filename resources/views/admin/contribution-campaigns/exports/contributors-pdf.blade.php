<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributors Export - {{ $contributionCampaign->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #2E86AB 0%, #A23B72 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .campaign-info {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #2E86AB;
        }

        .campaign-info h2 {
            color: #2E86AB;
            margin: 0 0 15px 0;
            font-size: 20px;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .contributors-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-header {
            background: linear-gradient(135deg, #2E86AB 0%, #A23B72 100%);
            color: white;
            padding: 20px;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }

        .table-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th {
            background: #f8f9fa;
            color: #333;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #e3f2fd;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .amount {
            font-weight: 600;
            color: #2E86AB;
        }

        .export-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #2E86AB;
        }

        .export-info p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-top: 3px solid #2E86AB;
        }

        .stat-number {
            font-size: 18px;
            font-weight: 700;
            color: #2E86AB;
            display: block;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 5px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .header,
            .campaign-info,
            .contributors-table {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Contributors Report</h1>
        <p>Campaign: {{ $contributionCampaign->name }}</p>
        <p>Generated on {{ $exportDate->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="campaign-info">
        <h2>Campaign Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Campaign Name</span>
                <span class="info-value">{{ $contributionCampaign->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Type</span>
                <span class="info-value">{{ ucfirst($contributionCampaign->type) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value">{{ ucfirst($contributionCampaign->status) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Start Date</span>
                <span class="info-value">{{ $contributionCampaign->start_date->format('M j, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">End Date</span>
                <span class="info-value">{{ $contributionCampaign->end_date->format('M j, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Target Amount</span>
                <span class="info-value">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->target_amount ?? 0, 2) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Current Amount</span>
                <span class="info-value">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->current_amount, 2) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Min Amount Per Person</span>
                <span class="info-value">{{ $contributionCampaign->currency }} {{ number_format($contributionCampaign->min_amount_per_person ?? 0, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="summary-stats">
        <div class="stat-card">
            <span class="stat-number">{{ $contributors->count() }}</span>
            <span class="stat-label">Total Contributors</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $contributionCampaign->currency }} {{ number_format($contributors->sum('amount'), 2) }}</span>
            <span class="stat-label">Total Raised</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $contributionCampaign->currency }} {{ number_format($contributors->avg('amount'), 2) }}</span>
            <span class="stat-label">Average Contribution</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $contributors->where('status', 'completed')->count() }}</span>
            <span class="stat-label">Completed</span>
        </div>
    </div>

    <div class="contributors-table">
        <div class="table-header">
            <h2>Contributors List</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Contributor Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                    <th>Reference</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contributors as $contributor)
                <tr>
                    <td><strong>{{ $contributor->contributor_name }}</strong></td>
                    <td>{{ $contributor->contributor_email ?? 'N/A' }}</td>
                    <td>{{ $contributor->contributor_phone ?? 'N/A' }}</td>
                    <td class="amount">{{ number_format($contributor->amount, 2) }}</td>
                    <td>{{ $contributor->currency }}</td>
                    <td>{{ $contributor->contribution_date->format('M j, Y') }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $contributor->payment_method)) }}</td>
                    <td>{{ $contributor->reference_number ?? 'N/A' }}</td>
                    <td>
                        <span class="status-badge status-{{ $contributor->status }}">
                            {{ ucfirst($contributor->status) }}
                        </span>
                    </td>
                    <td>{{ $contributor->notes ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 40px; color: #666;">
                        No contributors found for this campaign.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="export-info">
        <p><strong>Export Information:</strong> This report was generated on {{ $exportDate->format('F j, Y \a\t g:i A') }} for campaign "{{ $contributionCampaign->name }}".</p>
        <p><strong>Total Records:</strong> {{ $contributors->count() }} contributors</p>
    </div>
</body>

</html>