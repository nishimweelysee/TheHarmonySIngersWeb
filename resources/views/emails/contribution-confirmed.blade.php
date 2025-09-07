<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribution {{ ucfirst($contribution->status) }} - The Harmony Singers Choir</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f9fa;
    }

    .email-container {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #2E86AB 0%, #A23B72 100%);
        color: white;
        padding: 30px;
        text-align: center;
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 16px;
    }

    .content {
        padding: 30px;
    }

    .greeting {
        font-size: 18px;
        margin-bottom: 20px;
        color: #2E86AB;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 20px;
    }

    .status-confirmed {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-completed {
        background-color: #cce5ff;
        color: #004085;
        border: 1px solid #b3d7ff;
    }

    .contribution-details {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        border-left: 4px solid #2E86AB;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
    }

    .detail-value {
        color: #212529;
    }

    .amount-highlight {
        font-size: 20px;
        font-weight: 700;
        color: #2E86AB;
    }

    .message {
        margin: 20px 0;
        font-size: 16px;
        line-height: 1.7;
    }

    .thank-you {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        text-align: center;
        border: 1px solid #dee2e6;
    }

    .thank-you h3 {
        color: #2E86AB;
        margin: 0 0 10px 0;
        font-size: 18px;
    }

    .footer {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: center;
        border-top: 1px solid #dee2e6;
        color: #6c757d;
        font-size: 14px;
    }

    .logo {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        background-color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #2E86AB;
        font-weight: bold;
    }

    .contact-info {
        margin-top: 15px;
        font-size: 13px;
    }

    .contact-info a {
        color: #2E86AB;
        text-decoration: none;
    }

    .contact-info a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">THS</div>
            <h1>The Harmony Singers Choir</h1>
            <p>Contribution {{ ucfirst($contribution->status) }} Notification</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Dear {{ $contribution->contributor_name }},
            </div>

            <div class="message">
                We are pleased to inform you that your contribution has been
                <span class="status-badge status-{{ $contribution->status }}">
                    {{ $contribution->status }}
                </span>
            </div>

            <!-- Contribution Details -->
            <div class="contribution-details">
                <div class="detail-row">
                    <span class="detail-label">Campaign:</span>
                    <span class="detail-value">{{ $campaign->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Amount:</span>
                    <span class="detail-value amount-highlight">
                        {{ $contribution->currency }} {{ number_format($contribution->amount, 2) }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $contribution->contribution_date->format('F j, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span
                        class="detail-value">{{ ucfirst(str_replace('_', ' ', $contribution->payment_method)) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">{{ ucfirst($contribution->status) }}</span>
                </div>
                @if($contribution->reference_number)
                <div class="detail-row">
                    <span class="detail-label">Reference Number:</span>
                    <span class="detail-value">{{ $contribution->reference_number }}</span>
                </div>
                @endif
                @if($contribution->notes)
                <div class="detail-row">
                    <span class="detail-label">Notes:</span>
                    <span class="detail-value">{{ $contribution->notes }}</span>
                </div>
                @endif
            </div>

            <!-- Thank You Message -->
            <div class="thank-you">
                <h3>Thank You for Your Support!</h3>
                <p>Your generous contribution helps us continue our mission of bringing beautiful music to our
                    community. We truly appreciate your support and commitment to The Harmony Singers Choir.</p>
            </div>

            <div class="message">
                If you have any questions about your contribution or would like to learn more about our upcoming events
                and programs, please don't hesitate to contact us.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>The Harmony Singers Choir Team</strong></p>
            <div class="contact-info">
                <p>Email: <a href="mailto:info@harmonysingers.org">info@harmonysingers.org</a></p>
                <p>Phone: <a href="tel:+250123456789">+250 123 456 789</a></p>
                <p>Website: <a href="https://harmonysingers.org">harmonysingers.org</a></p>
            </div>
            <p style="margin-top: 15px; font-size: 12px; color: #adb5bd;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>

</html>