<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates - {{ $totalCount }} Members</title>

    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            line-height: 1.6;
            color: #1a202c;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Page Break for Each Certificate */
        .certificate-page {
            page-break-after: always;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
        }

        .certificate-page:last-child {
            page-break-after: avoid;
        }

        /* Certificate Container */
        .certificate-wrapper {
            width: 100%;
            max-width: 800px;
            height: 100vh;
            background: #ffffff;
            border-radius: 25px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
            border: 3px solid #f7fafc;
            display: flex;
            flex-direction: column;
            page-break-inside: avoid;
        }

        /* Decorative Corners */
        .corner-decoration {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 3px solid #667eea;
            opacity: 0.6;
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

        /* Certificate Header */
        .certificate-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #ffffff;
            padding: 30px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            border-bottom: 3px solid #1d4ed8;
        }

        .certificate-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 2px, transparent 2px),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 2px, transparent 2px),
                radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px, 30px 30px, 20px 20px;
            opacity: 0.4;
        }

        .certificate-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            z-index: 1;
        }

        .certificate-title {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 10px;
            text-shadow:
                0 4px 8px rgba(0, 0, 0, 0.9),
                0 8px 16px rgba(0, 0, 0, 0.7),
                0 0 40px rgba(255, 255, 255, 0.6);
            position: relative;
            z-index: 2;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #1e293b;
            ;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.8));
        }

        .certificate-subtitle {
            font-size: 1.3rem;
            opacity: 1;
            font-weight: 700;
            position: relative;
            z-index: 2;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #1e293b;
            ;
            text-shadow:
                0 3px 6px rgba(0, 0, 0, 0.9),
                0 6px 12px rgba(0, 0, 0, 0.6),
                0 0 30px rgba(255, 255, 255, 0.5);
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.7));
        }

        .certificate-logo {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #1e293b;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Certificate Content */
        .certificate-content {
            padding: 40px 50px;
            text-align: center;
            background: #ffffff;
            position: relative;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .certificate-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .member-name {
            font-size: 2.8rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
            position: relative;
        }

        .member-name::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
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

        /* Scripture Section */
        .scripture-section {
            margin: 25px 0;
            padding: 25px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            border: 2px solid #e2e8f0;
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .scripture-section::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 4rem;
            color: #667eea;
            font-weight: 800;
            opacity: 0.3;
        }

        .scripture-quote {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .verse-text {
            font-size: 1.1rem;
            color: #2d3748;
            font-style: italic;
            margin: 15px 0;
            line-height: 1.6;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .verse-reference {
            font-size: 1.1rem;
            color: #667eea;
            font-weight: 700;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Appreciation Section */
        .appreciation-section {
            margin: 30px 0;
            padding: 25px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 12px;
            border: 2px solid #f59e0b;
        }

        .appreciation-text {
            font-size: 1rem;
            color: #374151;
            line-height: 1.7;
            text-align: center;
            font-weight: 500;
        }

        /* Member Details */
        .certificate-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin: 25px 0;
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            border: 1px solid #e2e8f0;
        }

        .detail-item {
            text-align: center;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
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
            padding: 25px 40px;
            text-align: center;
            border-top: 3px solid #667eea;
            flex-shrink: 0;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .certificate-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .signature-section {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 20px;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .signature-line {
            flex: 1;
            min-width: 0;
            text-align: center;
            position: relative;
        }

        .signature-line hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            margin-bottom: 8px;
            border-radius: 1px;
            box-shadow: 0 1px 2px rgba(102, 126, 234, 0.3);
        }

        .signature-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .signature-title {
            font-size: 0.8rem;
            color: #475569;
            font-weight: 500;
            font-style: italic;
        }

        .certificate-number {
            font-size: 0.9rem;
            color: #475569;
            margin-top: 15px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 8px;
            display: inline-block;
            border: 1px solid #667eea;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.15);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(102, 126, 234, 0.03);
            font-weight: 900;
            pointer-events: none;
            z-index: 0;
        }

        /* Print Styles */
        @media print {
            body {
                background: #ffffff;
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
    </style>
</head>

<body>
    @foreach($certificates as $index => $certificate)
    <div class="certificate-page">
        <!-- Certificate Display -->
        <div class="certificate-wrapper">
            <!-- Decorative Corners -->
            <div class="corner-decoration top-left"></div>
            <div class="corner-decoration top-right"></div>
            <div class="corner-decoration bottom-left"></div>
            <div class="corner-decoration bottom-right"></div>

            <!-- Watermark -->
            <div class="watermark">THS</div>

            <!-- Certificate Header -->
            <div class="certificate-header">
                <div class="certificate-logo">
                    <i class="fas fa-music"></i>
                </div>
                <h1 class="certificate-title">The Harmony Singers</h1>
                <p class="certificate-subtitle">Official Membership Certificate</p>
            </div>

            <!-- Certificate Content -->
            <div class="certificate-content">
                <h2 class="member-name">{{ $certificate['member']->full_name }}</h2>

                <!-- Scripture Quote -->
                <div class="scripture-section">
                    <div class="scripture-quote">
                        <p class="verse-text">"{{ $certificate['bibleVerse']['text'] }}"</p>
                        <p class="verse-reference">{{ $certificate['bibleVerse']['reference'] }}</p>
                    </div>
                </div>

                <p class="certificate-text">
                    This is to certify that <strong>{{ $certificate['member']->full_name }}</strong> is an official
                    member of
                    <strong>The Harmony Singers</strong> choir, having joined our musical family and contributed
                    to the beautiful harmony we create together.
                </p>

                <!-- Appreciation Message -->
                <div class="appreciation-section">
                    <p class="appreciation-text">
                        {{ $certificate['additionalVerse']['text'] }}
                    </p>
                </div>
            </div>

            <!-- Certificate Footer -->
            <div class="certificate-footer">
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
                    Certificate #:
                    HS-{{ $certificate['member']->id }}-{{ $certificate['member']->join_date->format('Y') }}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>