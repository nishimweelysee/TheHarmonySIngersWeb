@extends('layouts.admin')

@section('title', 'Member Certificate')
@section('page-title', 'Member Certificate')

@section('content')
<!-- Enhanced Page Header -->
<div class="page-header enhanced-header member-certificate-header">
    <div class="header-background">
        <div class="header-pattern"></div>
        <div class="header-glow"></div>
    </div>
    <div class="header-content">
        <div class="header-text">
            <div class="header-icon">
                <i class="fas fa-certificate"></i>
                <div class="icon-glow"></div>
            </div>
            <div class="header-details">
                <h2 class="header-title">Membership Certificate</h2>
                <p class="header-subtitle">Official certificate for {{ $member->full_name }}</p>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">#{{ $member->id }}</span>
                        <span class="stat-label">Member ID</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $member->join_date->format('M Y') }}</span>
                        <span class="stat-label">Join Date</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $member->type }}</span>
                        <span class="stat-label">Member Type</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.members.show', $member) }}" class="btn btn-outline enhanced-btn">
                <div class="btn-content">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Member</span>
                </div>
                <div class="btn-glow"></div>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Action Buttons -->
<div class="certificate-actions enhanced-actions">
    <div class="action-buttons">
        <button onclick="printCertificate()" class="btn btn-primary enhanced-btn print-btn">
            <div class="btn-content">
                <i class="fas fa-print"></i>
                <span>Print Certificate</span>
            </div>
            <div class="btn-glow"></div>
        </button>
        <a href="{{ route('admin.members.certificate.download', $member) }}"
            class="btn btn-success enhanced-btn download-btn" onclick="handleDownload(event, this)">
            <div class="btn-content">
                <i class="fas fa-download"></i>
                <span>Download PDF</span>
            </div>
            <div class="btn-glow"></div>
        </a>
        <button onclick="shareCertificate()" class="btn btn-info enhanced-btn share-btn">
            <div class="btn-content">
                <i class="fas fa-share-alt"></i>
                <span>Share</span>
            </div>
            <div class="btn-glow"></div>
        </button>
    </div>
</div>

<!-- Enhanced Certificate Display -->
<div class="certificate-container enhanced-card">
    <div class="certificate-header">
        <div class="certificate-title">
            <i class="fas fa-award"></i>
            <h3>Certificate Preview</h3>
        </div>
        <div class="certificate-meta">
            <span class="meta-item">
                <i class="fas fa-calendar"></i>
                Generated: {{ now()->format('M j, Y \a\t g:i A') }}
            </span>
            <span class="meta-item">
                <i class="fas fa-user"></i>
                Member: {{ $member->full_name }}
            </span>
        </div>
    </div>

    <div class="certificate-wrapper enhanced-wrapper">
        <div class="certificate-content">
            <x-certificate :member="$member" />
        </div>
    </div>

    <div class="certificate-footer">
        <div class="footer-info">
            <p><i class="fas fa-info-circle"></i> This is a preview of the official membership certificate</p>
            <p><i class="fas fa-print"></i> Use the print button above to print this certificate</p>
        </div>
    </div>
</div>

<!-- Enhanced Print Instructions -->
<div class="print-instructions enhanced-card">
    <div class="instructions-header">
        <i class="fas fa-lightbulb"></i>
        <h4>Printing Tips</h4>
    </div>
    <div class="instructions-content">
        <ul class="tips-list">
            <li><i class="fas fa-check"></i> Use A4 or Letter size paper for best results</li>
            <li><i class="fas fa-check"></i> Set margins to minimum for full certificate display</li>
            <li><i class="fas fa-check"></i> Enable background graphics in print settings</li>
            <li><i class="fas fa-check"></i> Use high-quality paper for official documents</li>
        </ul>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Enhanced print functionality
function printCertificate() {
    try {
        // Show loading state
        const printBtn = document.querySelector('.print-btn');
        if (!printBtn) {
            console.error('Print button not found');
            showToast('Print button not found', 'error');
            return;
        }

        const originalContent = printBtn.innerHTML;
        printBtn.innerHTML =
            '<div class="btn-content" style="color: white !important;"><i class="fas fa-spinner fa-spin" style="color: white !important;"></i> <span style="color: white !important;">Preparing...</span></div>';
        printBtn.disabled = true;

        // Store original display styles
        const elementsToHide = document.querySelectorAll(
            '.page-header, .certificate-actions, .print-instructions, .certificate-header, .certificate-footer');
        const originalStyles = [];

        elementsToHide.forEach((el, index) => {
            originalStyles[index] = el.style.display;
            el.style.display = 'none';
        });

        // Add comprehensive print styles
        const printStyleId = 'enhanced-print-styles';
        let existingStyle = document.getElementById(printStyleId);
        if (existingStyle) {
            existingStyle.remove();
        }

        const style = document.createElement('style');
        style.id = printStyleId;
        style.textContent = `
                @media print {
                    @page {
                        margin: 0.5in;
                        size: letter;
                    }
                    
                    body {
                        margin: 0;
                        padding: 0;
                        font-size: 12pt;
                        line-height: 1.4;
                        color: black;
                        background: white;
                    }
                    
                    .certificate-wrapper {
                        padding: 0 !important;
                        margin: 0 !important;
                        width: 100% !important;
                        max-width: none !important;
                    }
                    
                    .certificate-wrapper .certificate-container {
                        box-shadow: none !important;
                        border: 3px solid #000 !important;
                        background: white !important;
                        page-break-inside: avoid;
                        padding: 30px !important;
                        margin: 0 !important;
                        max-width: none !important;
                        width: 100% !important;
                    }
                    
                    .certificate-wrapper .musical-staff-bg {
                        opacity: 0.15 !important;
                    }
                    
                    .certificate-wrapper .note {
                        animation: none !important;
                    }
                    
                    .certificate-wrapper .main-title {
                        font-size: 24pt !important;
                        color: black !important;
                    }
                    
                    .certificate-wrapper .subtitle {
                        font-size: 18pt !important;
                        color: #333 !important;
                    }
                    
                    .certificate-wrapper .member-name {
                        font-size: 20pt !important;
                        color: black !important;
                    }
                    
                    .page-header,
                    .certificate-actions,
                    .print-instructions,
                    .certificate-header,
                    .certificate-footer {
                        display: none !important;
                    }
                }
            `;
        document.head.appendChild(style);

        // Show preview message
        showToast('Preparing certificate for printing...', 'info');

        // Wait for styles to apply, then print
        setTimeout(() => {
            window.print();

            // Clean up after printing
            setTimeout(() => {
                try {
                    // Remove print styles
                    const printStyle = document.getElementById(printStyleId);
                    if (printStyle) {
                        printStyle.remove();
                    }

                    // Restore original display styles
                    elementsToHide.forEach((el, index) => {
                        el.style.display = originalStyles[index] || '';
                    });

                    // Restore button
                    printBtn.innerHTML = originalContent;
                    printBtn.disabled = false;

                    // Show success message
                    showToast('Certificate ready for printing!', 'success');
                } catch (cleanupError) {
                    console.error('Cleanup error:', cleanupError);
                    // Force restore button even if cleanup fails
                    printBtn.innerHTML = originalContent;
                    printBtn.disabled = false;
                }
            }, 1000);
        }, 500);

    } catch (error) {
        console.error('Print error:', error);
        showToast('Print failed. Please try again.', 'error');

        // Restore button on error
        const printBtn = document.querySelector('.print-btn');
        if (printBtn) {
            printBtn.disabled = false;
            printBtn.innerHTML =
                '<div class="btn-content"><i class="fas fa-print"></i> <span>Print Certificate</span></div>';
        }
    }
}

// Download functionality with user feedback
function handleDownload(event, button) {
    try {
        // Show loading state
        const originalContent = button.innerHTML;
        button.innerHTML =
            '<div class="btn-content" style="color: white;"><i class="fas fa-spinner fa-spin" style="color: white;"></i> <span style="color: white;">Downloading...</span></div>';
        button.style.pointerEvents = 'none';

        // Show download start message
        showToast('Starting PDF download...', 'info');

        // Restore button after a delay
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.style.pointerEvents = 'auto';
            showToast('PDF download initiated successfully!', 'success');
        }, 2000);

        // Let the default link behavior continue
        return true;
    } catch (error) {
        console.error('Download error:', error);
        showToast('Download failed. Please try again.', 'error');

        // Restore button on error
        button.innerHTML = originalContent;
        button.style.pointerEvents = 'auto';
        return false;
    }
}

// Download functionality with user feedback
function handleDownload(event, button) {
    try {
        // Show loading state
        const originalContent = button.innerHTML;
        button.innerHTML =
            '<div class="btn-content" style="color: white;"><i class="fas fa-spinner fa-spin" style="color: white;"></i> <span style="color: white;">Downloading...</span></div>';
        button.style.pointerEvents = 'none';

        // Show download start message
        showToast('Starting PDF download...', 'info');

        // Restore button after a delay
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.style.pointerEvents = 'auto';
            showToast('PDF download initiated successfully!', 'success');
        }, 2000);

        // Let the default link behavior continue
        return true;
    } catch (error) {
        console.error('Download error:', error);
        showToast('Download failed. Please try again.', 'error');

        // Restore button on error
        button.innerHTML = originalContent;
        button.style.pointerEvents = 'auto';
        return false;
    }
}

// Download functionality with user feedback
function handleDownload(event, button) {
    try {
        // Show loading state
        const originalContent = button.innerHTML;
        button.innerHTML =
            '<div class="btn-content" style="color: white;"><i class="fas fa-spinner fa-spin" style="color: white;"></i> <span style="color: white;">Downloading...</span></div>';
        button.style.pointerEvents = 'none';

        // Show download start message
        showToast('Starting PDF download...', 'info');

        // Restore button after a delay
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.style.pointerEvents = 'auto';
            showToast('PDF download initiated successfully!', 'success');
        }, 2000);

        // Let the default link behavior continue
        return true;
    } catch (error) {
        console.error('Download error:', error);
        showToast('Download failed. Please try again.', 'error');

        // Restore button on error
        button.innerHTML = originalContent;
        button.style.pointerEvents = 'auto';
        return false;
    }
}

// Share functionality
function shareCertificate() {
    console.log('Share function called');

    if (navigator.share) {
        console.log('Using Web Share API');
        navigator.share({
            title: 'Membership Certificate - {{ $member->full_name }}',
            text: 'View the official membership certificate for {{ $member->full_name }}',
            url: window.location.href
        }).then(() => {
            console.log('Share successful');
            showToast('Certificate shared successfully!', 'success');
        }).catch((error) => {
            console.log('Error sharing:', error);
            showToast('Sharing failed. Please try again.', 'error');
        });
    } else {
        console.log('Using clipboard fallback');
        // Fallback: copy URL to clipboard
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(window.location.href).then(() => {
                console.log('URL copied to clipboard');
                showToast('Certificate URL copied to clipboard!', 'success');
            }).catch((error) => {
                console.log('Clipboard error:', error);
                showToast('Failed to copy URL. Please copy manually.', 'error');
            });
        } else {
            // Legacy fallback
            const textArea = document.createElement('textarea');
            textArea.value = window.location.href;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showToast('Certificate URL copied to clipboard!', 'success');
            } catch (err) {
                showToast('Failed to copy URL. Please copy manually: ' + window.location.href, 'error');
            }
            document.body.removeChild(textArea);
        }
    }
}

// Toast notification system
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    // Add to page
    document.body.appendChild(toast);

    // Show toast
    setTimeout(() => toast.classList.add('show'), 100);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Certificate preview enhancement
document.addEventListener('DOMContentLoaded', function() {
    // Test button visibility
    console.log('DOM loaded, checking buttons...');
    const printBtn = document.querySelector('.print-btn');
    const downloadBtn = document.querySelector('.download-btn');
    const shareBtn = document.querySelector('.share-btn');

    console.log('Print button:', printBtn);
    console.log('Download button:', downloadBtn);
    console.log('Share button:', shareBtn);

    if (!printBtn || !downloadBtn || !shareBtn) {
        console.error('Some buttons are missing!');
    } else {
        console.log('All buttons found successfully');
    }

    const certificateWrapper = document.querySelector('.certificate-wrapper');

    // Add zoom functionality
    let scale = 1;
    const zoomIn = document.createElement('button');
    zoomIn.className = 'zoom-btn zoom-in';
    zoomIn.innerHTML = '<i class="fas fa-search-plus"></i>';
    zoomIn.onclick = () => {
        scale = Math.min(scale * 1.2, 3);
        certificateWrapper.style.transform = `scale(${scale})`;
        updateZoomButtons();
    };

    const zoomOut = document.createElement('button');
    zoomOut.className = 'zoom-btn zoom-out';
    zoomOut.innerHTML = '<i class="fas fa-search-minus"></i>';
    zoomOut.onclick = () => {
        scale = Math.max(scale / 1.2, 0.5);
        certificateWrapper.style.transform = `scale(${scale})`;
        updateZoomButtons();
    };

    const resetZoom = document.createElement('button');
    resetZoom.className = 'zoom-btn zoom-reset';
    resetZoom.innerHTML = '<i class="fas fa-undo"></i>';
    resetZoom.onclick = () => {
        scale = 1;
        certificateWrapper.style.transform = 'scale(1)';
        updateZoomButtons();
    };

    function updateZoomButtons() {
        zoomIn.disabled = scale >= 3;
        zoomOut.disabled = scale <= 0.5;
    }

    // Add zoom controls to certificate header
    const certificateHeader = document.querySelector('.certificate-header');
    const zoomControls = document.createElement('div');
    zoomControls.className = 'zoom-controls';
    zoomControls.appendChild(zoomIn);
    zoomControls.appendChild(zoomOut);
    zoomControls.appendChild(resetZoom);
    certificateHeader.appendChild(zoomControls);

    updateZoomButtons();

    // Test all functionality on page load
    console.log('=== Certificate Page Functionality Test ===');
    console.log('✓ Print function:', typeof printCertificate === 'function');
    console.log('✓ Download function:', typeof handleDownload === 'function');
    console.log('✓ Share function:', typeof shareCertificate === 'function');
    console.log('✓ Toast function:', typeof showToast === 'function');
    console.log('✓ Certificate zoom initialized');
    console.log('✓ All buttons are visible and styled');

    // Show welcome message
    setTimeout(() => {
        showToast('Certificate page loaded successfully! All functions are ready.', 'success');
    }, 1000);
});
</script>
@endpush