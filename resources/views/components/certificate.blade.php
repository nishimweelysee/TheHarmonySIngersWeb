@props(['member'])

<div class="certificate-container">
    <!-- Musical Staff Background -->
    <div class="musical-staff-bg">
        <div class="staff-lines"></div>
        <div class="musical-notes">
            <div class="note note-1">♪</div>
            <div class="note note-2">♫</div>
            <div class="note note-3">♩</div>
            <div class="note note-4">♬</div>
            <div class="note note-5">♭</div>
            <div class="note note-6">♯</div>
        </div>
    </div>

    <!-- Decorative Border -->
    <div class="certificate-border">
        <div class="corner-decoration top-left"></div>
        <div class="corner-decoration top-right"></div>
        <div class="corner-decoration bottom-left"></div>
        <div class="corner-decoration bottom-right"></div>
    </div>

    <!-- Certificate Content -->
    <div class="certificate-content">
        <!-- Header Section -->
        <div class="certificate-header-section">
            <div class="logo-section">
                <div class="choir-logo">
                    <i class="fas fa-music"></i>
                </div>
            </div>
            <h1 class="main-title">THE HARMONY SINGERS</h1>
            <h2 class="subtitle">CERTIFICATE OF MEMBERSHIP</h2>
            <div class="title-underline"></div>
            <p class="presenter-line">PRESENTED BY: THE HARMONY SINGERS CHOIR DIRECTOR</p>
        </div>

        <!-- Member Name -->
        <div class="member-name-section">
            <h3 class="member-name">{{ $member->full_name }}</h3>
            <div class="name-underline"></div>
        </div>

        <!-- Scripture Quote -->
        <div class="scripture-section">
            <div class="scripture-quote">
                <div class="quote-marks">"</div>
                <p class="verse-text">O COME, LET US SING UNTO THE LORD: LET US MAKE A JOYFUL NOISE TO THE ROCK OF OUR SALVATION.</p>
                <div class="quote-marks">"</div>
                <p class="verse-reference">PSALMS 95:1</p>
            </div>
        </div>

        <!-- Appreciation Message -->
        <div class="appreciation-section">
            <p class="appreciation-text">WE, THE MEMBERS OF THE HARMONY SINGERS CHOIR WANT YOU TO KNOW, THAT WE LOVE AND APPRECIATE YOU. WE THANK GOD FOR YOU, AND FOR MINISTERING IN SONGS. WE PRAY CONTINUED BLESSINGS TO YOU AND YOUR FAMILIES.</p>
        </div>

        <!-- Member Details -->
        <div class="member-details-section">
            <div class="member-info-card">
                <p class="member-info">
                    @if($member->type === 'singer')
                    ACTIVE MEMBER AS A <strong>{{ strtoupper($member->voice_part ?? 'CHOIR') }}</strong> SINGER
                    @else
                    ACTIVE MEMBER OF THE HARMONY SINGERS ORGANIZATION
                    @endif
                    SINCE {{ strtoupper($member->join_date->format('F j, Y')) }}
                </p>
                <div class="member-id">
                    MEMBER ID: #{{ $member->id }}
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-line">
                <div class="line"></div>
                <div class="label">CHOIR DIRECTOR</div>
            </div>
            <div class="signature-line">
                <div class="line"></div>
                <div class="label">CHOIR PRESIDENT</div>
            </div>
        </div>

        <!-- Date Section -->
        <div class="date-section">
            <p class="certificate-date">ISSUED ON: {{ strtoupper(now()->format('F j, Y')) }}</p>
        </div>
    </div>

    <!-- Certificate Number -->
    <div class="certificate-number">
        CERTIFICATE #{{ str_pad($member->id, 4, '0', STR_PAD_LEFT) }}-{{ $member->join_date->format('Y') }}
    </div>

    <!-- Watermark -->
    <div class="watermark">THS</div>
</div>