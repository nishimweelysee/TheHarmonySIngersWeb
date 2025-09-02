<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-mobile-web-app-capable" content="yes">
    <meta name="x-apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="x-apple-mobile-web-app-title" content="THS">
    <meta name="msapplication-TileColor" content="#1a365d">
    <meta name="theme-color" content="#1a365d">
    <title>{{ config('app.name') }}</title>
    <style>
        /* THS Brand Colors */
        :root {
            --ths-primary: #1a365d;
            /* Deep Blue */
            --ths-secondary: #2d3748;
            /* Dark Gray */
            --ths-accent: #e53e3e;
            /* Red */
            --ths-gold: #d69e2e;
            /* Gold */
            --ths-light: #f7fafc;
            /* Light Gray */
            --ths-white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: var(--ths-secondary);
            background-color: var(--ths-light);
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: var(--ths-white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, var(--ths-primary) 0%, var(--ths-secondary) 100%);
            color: var(--ths-white);
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .email-header::before {
            content: '🎵';
            font-size: 48px;
            display: block;
            margin-bottom: 10px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: var(--ths-white);
        }

        .email-header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .email-content {
            padding: 40px 30px;
            background-color: var(--ths-white);
        }

        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: var(--ths-primary);
            margin-bottom: 20px;
            border-bottom: 2px solid var(--ths-gold);
            padding-bottom: 10px;
        }

        .content-line {
            margin-bottom: 15px;
            font-size: 16px;
            line-height: 1.6;
        }

        .content-line strong {
            color: var(--ths-primary);
        }

        .content-line em {
            color: var(--ths-accent);
            font-style: normal;
        }

        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, var(--ths-accent) 0%, #c53030 100%);
            color: var(--ths-white);
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            margin: 25px 0;
            text-align: center;
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3);
            transition: all 0.3s ease;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 62, 62, 0.4);
        }

        .footer {
            background-color: var(--ths-secondary);
            color: var(--ths-white);
            padding: 30px 20px;
            text-align: center;
        }

        .footer h3 {
            margin: 0 0 15px 0;
            font-size: 18px;
            color: var(--ths-gold);
        }

        .footer p {
            margin: 5px 0;
            font-size: 14px;
            opacity: 0.8;
        }

        .ths-logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--ths-gold);
            margin-bottom: 10px;
        }

        .highlight-box {
            background: linear-gradient(135deg, var(--ths-light) 0%, #edf2f7 100%);
            border-left: 4px solid var(--ths-gold);
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .highlight-box h4 {
            margin: 0 0 10px 0;
            color: var(--ths-primary);
            font-size: 18px;
        }

        .highlight-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .highlight-box li {
            margin-bottom: 5px;
            color: var(--ths-secondary);
        }

        @media only screen and (max-width: 600px) {
            .email-wrapper {
                margin: 0;
                border-radius: 0;
            }

            .email-content {
                padding: 30px 20px;
            }

            .email-header {
                padding: 20px 15px;
            }

            .email-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>The Harmony Singers Choir</h1>
            <p>Creating Beautiful Harmonies, Inspiring Communities</p>
        </div>

        <div class="email-content">
            @if (isset($greeting))
            <div class="greeting">{{ $greeting }}</div>
            @endif

            @foreach ($introLines as $line)
            <div class="content-line">{{ $line }}</div>
            @endforeach

            @if (isset($actionText))
            <div style="text-align: center;">
                <a href="{{ $actionUrl }}" class="action-button">
                    {{ $actionText }}
                </a>
            </div>
            @endif

            @foreach ($outroLines as $line)
            <div class="content-line">{{ $line }}</div>
            @endforeach

            @if (isset($salutation))
            <div class="content-line">{{ $salutation }}</div>
            @endif
        </div>

        <div class="footer">
            <div class="ths-logo">THS</div>
            <h3>The Harmony Singers Choir</h3>
            <p>🎵 Spreading Joy Through Music 🎵</p>
            <p>🌟 Inspiring Communities 🌟</p>
            <p>🎭 Building Lasting Harmonies 🎭</p>
            <p style="margin-top: 20px; font-size: 12px; opacity: 0.6;">
                This email was sent from The Harmony Singers Choir Portal
            </p>
        </div>
    </div>
</body>

</html>