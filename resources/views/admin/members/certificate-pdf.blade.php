<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $member->full_name }}</title>

    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8fafc;
            padding: 20px;
        }

        /* Certificate Container */
        .certificate-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }

        /* Certificate Header */
        .certificate-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .certificate-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .certificate-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .certificate-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
            position: relative;
            z-index: 1;
        }

        .certificate-logo {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            backdrop-filter: blur(10px);
        }

        /* Certificate Content */
        .certificate-content {
            padding: 60px 40px;
            text-align: center;
            background: white;
            position: relative;
        }

        .certificate-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
        }

        .member-name {
            font-size: 2.8rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .certificate-text {
            font-size: 1.3rem;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.8;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .certificate-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            border: 1px solid #e2e8f0;
        }

        .detail-item {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            transition: transform 0.3s ease;
        }

        .detail-item:hover {
            transform: translateY(-5px);
        }

        .detail-label {
            font-size: 0.9rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #1e293b;
            font-weight: 700;
        }

        /* Certificate Footer */
        .certificate-footer {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-line {
            flex: 1;
            margin: 0 20px;
            text-align: center;
        }

        .signature-line hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            margin-bottom: 10px;
        }

        .signature-name {
            font-size: 1rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 5px;
        }

        .signature-title {
            font-size: 0.9rem;
            color: #64748b;
        }

        .certificate-number {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            display: inline-block;
            border: 1px solid #e2e8f0;
        }

        /* Decorative Elements */
        .corner-decoration {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 3px solid #3b82f6;
            opacity: 0.3;
        }

        .corner-decoration.top-left {
            top: 20px;
            left: 20px;
            border-right: none;
            border-bottom: none;
        }

        .corner-decoration.top-right {
            top: 20px;
            right: 20px;
            border-left: none;
            border-bottom: none;
        }

        .corner-decoration.bottom-left {
            bottom: 20px;
            left: 20px;
            border-right: none;
            border-top: none;
        }

        .corner-decoration.bottom-right {
            bottom: 20px;
            right: 20px;
            border-left: none;
            border-top: none;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(59, 130, 246, 0.03);
            font-weight: 900;
            pointer-events: none;
            z-index: 0;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .certificate-wrapper {
                box-shadow: none;
                border: none;
                border-radius: 0;
            }

            .corner-decoration {
                display: none;
            }

            .watermark {
                display: none;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .certificate-header {
                padding: 30px 20px;
            }

            .certificate-title {
                font-size: 2rem;
            }

            .certificate-content {
                padding: 40px 20px;
            }

            .member-name {
                font-size: 2.2rem;
            }

            .certificate-details {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 20px;
            }

            .signature-section {
                flex-direction: column;
                gap: 20px;
            }

            .signature-line {
                margin: 0;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Typography */
        .text-gradient {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
        }

        /* Date Display */
        .date-display {
            font-size: 1.1rem;
            color: #64748b;
            margin: 20px 0;
            padding: 15px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            display: inline-block;
        }

        .date-display i {
            margin-right: 8px;
            color: #3b82f6;
        }
    </style>
</head>

<body>
    <!-- Certificate Display -->
    <div class="certificate-wrapper fade-in">
        <!-- Decorative Corners -->
        <div class="corner-decoration top-left"></div>
        <div class="corner-decoration top-right"></div>
        <div class="corner-decoration bottom-left"></div>
        <div class="corner-decoration bottom-right"></div>

        <!-- Watermark -->
        <div class="watermark">HS</div>

        <!-- Certificate Header -->
        <div class="certificate-header slide-up">
            <div class="certificate-logo">
                <i class="fas fa-music"></i>
            </div>
            <h1 class="certificate-title">The Harmony Singers</h1>
            <p class="certificate-subtitle">Official Membership Certificate</p>
        </div>

        <!-- Certificate Content -->
        <div class="certificate-content slide-up">
            <h2 class="member-name text-shadow">{{ $member->full_name }}</h2>
            <p class="certificate-text">
                This is to certify that <strong>{{ $member->full_name }}</strong> is an official member of
                <strong>The Harmony Singers</strong> choir, having joined our musical family and contributed
                to the beautiful harmony we create together.
            </p>

            <!-- Member Details -->
            <div class="certificate-details slide-up">
                <div class="detail-item">
                    <div class="detail-label">Member ID</div>
                    <div class="detail-value">#{{ $member->id }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Member Type</div>
                    <div class="detail-value">{{ ucfirst($member->type) }}</div>
                </div>
                @if($member->voice_part)
                <div class="detail-item">
                    <div class="detail-label">Voice Part</div>
                    <div class="detail-value">{{ ucfirst($member->voice_part) }}</div>
                </div>
                @endif
                <div class="detail-item">
                    <div class="detail-label">Join Date</div>
                    <div class="detail-value">{{ $member->join_date->format('M j, Y') }}</div>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="status-badge slide-up">
                <i class="fas fa-check-circle"></i>
                {{ $member->is_active ? 'Active Member' : 'Inactive Member' }}
            </div>

            <!-- Date Display -->
            <div class="date-display slide-up">
                <i class="fas fa-calendar-alt"></i>
                Certificate issued on {{ now()->format('F j, Y') }}
            </div>
        </div>

        <!-- Certificate Footer -->
        <div class="certificate-footer slide-up">
            <div class="signature-section">
                <div class="signature-line">
                    <hr>
                    <div class="signature-name">Choir Director</div>
                    <div class="signature-title">The Harmony Singers</div>
                </div>
                <div class="signature-line">
                    <hr>
                    <div class="signature-name">Board Chair</div>
                    <div class="signature-title">The Harmony Singers</div>
                </div>
            </div>

            <div class="certificate-number">
                Certificate #: HS-{{ $member->id }}-{{ $member->join_date->format('Y') }}
            </div>
        </div>
    </div>

    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>

</html>