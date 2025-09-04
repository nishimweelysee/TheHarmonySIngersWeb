@extends('layouts.public')

@section('title', 'Welcome')
@section('description', 'The Harmony Singers - A premier choir bringing beautiful music to our community through
passionate performances and dedication to excellence.')

@section('content')
<!-- Photo Slideshow Section -->
@if($slideshowImages->count() > 0)
<section class="photo-slideshow">
    <div class="slideshow-container">
        @foreach($slideshowImages as $index => $photo)
        <div class="slide {{ $index === 0 ? 'active' : '' }}"
            style="background-image: url('{{ asset('storage/' . $photo->file_path) }}')">
            <div class="slide-overlay">
                <div class="slide-content">
                    <h2 class="slide-title">{{ $photo->title }}</h2>
                    @if($photo->description)
                    <p class="slide-description">{{ $photo->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        <!-- Navigation arrows -->
        @if($slideshowImages->count() > 1)
        <a class="slide-nav prev" onclick="changeSlide(-1)">❮</a>
        <a class="slide-nav next" onclick="changeSlide(1)">❯</a>

        <!-- Dots indicator -->
        <div class="slide-dots">
            @foreach($slideshowImages as $index => $photo)
            <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="currentSlide({{ $index + 1 }})"></span>
            @endforeach
        </div>

        <!-- Slideshow info -->
        <div class="slideshow-info">
            <span class="slide-counter">{{ $slideshowImages->count() }} Photos</span>
        </div>
        @endif
    </div>
</section>
@else
<!-- Fallback hero section when no slideshow images -->
<section class="hero hero-fallback">
    <div class="hero-content">
        <h1>Welcome to The Harmony Singers</h1>
        <p>
            Experience the magic of choral music with our passionate community of singers
            dedicated to bringing beautiful harmonies to life in every performance.
        </p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('concerts.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-music"></i>
                View Upcoming Concerts
            </a>
            <a href="{{ route('media.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-play"></i>
                Listen to Our Music
            </a>
        </div>
    </div>
</section>
@endif

<!-- Statistics Section -->
<section class="section" style="background: var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Musical Impact</h2>
            <p class="section-subtitle">
                Numbers that tell our story of musical excellence and community engagement
            </p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_members'] }}</div>
                <div class="stat-label">Total Members</div>
                <div class="stat-description">Growing Family</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['singers'] }}</div>
                <div class="stat-label">Active Singers</div>
                <div class="stat-description">Beautiful Voices</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['upcoming_concerts'] }}</div>
                <div class="stat-label">Upcoming Concerts</div>
                <div class="stat-description">Don't Miss Out</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['years_active'] }}</div>
                <div class="stat-label">Years Active</div>
                <div class="stat-description">Legacy of Music</div>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Feed Section -->
<section class="section instagram-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fab fa-instagram"></i>
                Follow Our Journey
            </h2>
            <p class="section-subtitle">
                Stay connected with The Harmony Singers on Instagram for behind-the-scenes moments,
                performance highlights, and community updates
            </p>
        </div>

        <div class="instagram-container">
            <!-- Instagram Embed -->
            <div class="instagram-embed-wrapper">
                <div class="instagram-header">
                    <div class="instagram-profile">
                        <div class="profile-avatar">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="profile-info">
                            <h3>@harmonyfamily_</h3>
                            <p>The Harmony Singers</p>
                        </div>
                    </div>
                    <a href="https://www.instagram.com/harmonyfamily_/" target="_blank" rel="noopener noreferrer" class="follow-btn">
                        <i class="fab fa-instagram"></i>
                        Follow Us
                    </a>
                </div>

                <!-- Instagram Feed Embed -->
                <div class="instagram-feed">
                    <div class="scroll-indicator">
                        <i class="fas fa-chevron-down"></i>
                        <span>Scroll to see more posts</span>
                    </div>
                    <iframe
                        src="https://www.instagram.com/harmonyfamily_/embed/"
                        width="100%"
                        height="600"
                        frameborder="0"
                        scrolling="yes"
                        allowtransparency="true"
                        class="instagram-iframe">
                    </iframe>
                </div>
            </div>

            <!-- Instagram Highlights -->
            <div class="instagram-highlights">
                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <h4>Performance Videos</h4>
                    <p>Watch our latest performances and behind-the-scenes moments</p>
                </div>

                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Community Stories</h4>
                    <p>Meet our members and see the family we've built together</p>
                </div>

                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4>Event Updates</h4>
                    <p>Get the latest news about upcoming concerts and events</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="instagram-cta">
            <div class="cta-content">
                <h3>Join Our Instagram Family</h3>
                <p>Follow us for daily inspiration, musical moments, and community updates</p>
                <div class="cta-buttons">
                    <a href="https://www.instagram.com/harmonyfamily_/" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-lg">
                        <i class="fab fa-instagram"></i>
                        Follow on Instagram
                    </a>
                    <a href="https://tr.ee/jwyyD_5ueg" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-lg">
                        <i class="fas fa-link"></i>
                        All Social Links
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section">
    <div class="container">
        <div class="about-section-grid">
            <!-- Content -->
            <div class="about-content">
                <h2 class="section-title about-title">
                    Why Choose The Harmony Singers?
                </h2>
                <p class="about-description">
                    With over {{ $stats['years_active'] }} years of musical excellence, we've built a reputation
                    for outstanding performances and a welcoming community atmosphere. Our diverse repertoire
                    and professional approach make every concert a memorable experience.
                </p>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon feature-icon-primary">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="feature-content">
                            <h4 class="feature-title">Professional Quality</h4>
                            <p class="feature-description">Outstanding performances every time</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon feature-icon-accent">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-content">
                            <h4 class="feature-title">Welcoming Community</h4>
                            <p class="feature-description">Everyone is welcome to join our family</p>
                        </div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon feature-icon-success">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="feature-content">
                            <h4 class="feature-title">Diverse Repertoire</h4>
                            <p class="feature-description">From classical to contemporary music</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Highlights Card -->
            <div class="concerts-card">
                <div class="card-header">
                    <h3 class="card-title">Upcoming Concerts</h3>
                </div>
                <div class="card-body">
                    @if($upcomingConcerts->count() > 0)
                    <div class="concerts-list">
                        @foreach($upcomingConcerts->take(2) as $concert)
                        <div class="concert-item">
                            <h4 class="concert-title">{{ $concert->title }}</h4>
                            <p class="concert-date">
                                <i class="fas fa-calendar-alt"></i>
                                @if($concert->date)
                                {{ $concert->date->format('F j, Y') }}
                                @else
                                Date TBA
                                @endif
                            </p>
                            <p class="concert-venue">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $concert->venue }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="no-concerts">
                        <i class="fas fa-music"></i>
                        <p>More concerts coming soon!</p>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('concerts.index') }}" class="btn btn-primary concerts-btn">
                        <i class="fas fa-calendar"></i>
                        View All Concerts
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Media Section -->
@if($featuredMedia->count() > 0)
<section class="section" style="background: var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured Media</h2>
            <p class="section-subtitle">
                Explore our collection of photos, videos, and audio recordings from recent performances
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-6);">
            @foreach($featuredMedia->take(3) as $media)
            <div class="card">
                @if($media->type === 'photo')
                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}"
                    style="width: 100%; height: 200px; object-fit: cover;">
                @elseif($media->type === 'video')
                <div
                    style="width: 100%; height: 200px; background: var(--gray-800); display: flex; align-items: center; justify-content: center; position: relative;">
                    <i class="fas fa-play-circle" style="font-size: 4rem; color: white; opacity: 0.8;"></i>
                </div>
                @else
                <div
                    style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-music" style="font-size: 4rem; color: white; opacity: 0.8;"></i>
                </div>
                @endif
                <div class="card-body">
                    <h3 style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-2);">
                        {{ $media->title }}
                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem;">{{ Str::limit($media->description, 80) }}
                    </p>
                    <div style="margin-top: var(--space-3);">
                        <span
                            style="display: inline-block; padding: var(--space-1) var(--space-3); background: var(--gray-100); color: var(--gray-700); border-radius: var(--radius); font-size: 0.75rem; font-weight: 500;">
                            {{ ucfirst($media->type) }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: var(--space-12);">
            <a href="{{ route('media.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-images"></i>
                View All Media
            </a>
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="section"
    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white;">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: var(--space-6); color: white;">
            Ready to Join Our Musical Family?
        </h2>
        <p
            style="font-size: 1.25rem; margin-bottom: var(--space-8); opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
            Whether you're an experienced singer or just starting your musical journey, we'd love to have you join us.
            Contact us today to learn more about our choir.
        </p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('contact.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-envelope"></i>
                Contact Us
            </a>
            <a href="{{ route('concerts.index') }}"
                style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-4) var(--space-8); font-weight: 600; text-decoration: none; border-radius: var(--radius-lg); transition: var(--transition); cursor: pointer; border: 2px solid white; color: white; background: transparent; font-size: 1rem;"
                onmouseover="this.style.background='white'; this.style.color='var(--primary)'"
                onmouseout="this.style.background='transparent'; this.style.color='white'">
                <i class="fas fa-calendar"></i>
                Attend a Concert
            </a>
        </div>
    </div>
</section>

<style>
    /* Photo Slideshow Styles */
    .photo-slideshow {
        position: relative;
        height: 500px;
        overflow: hidden;
        margin-bottom: 0;
    }

    .slideshow-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    .slide.active {
        opacity: 1;
    }

    .slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slide-content {
        text-align: center;
        color: white;
        max-width: 600px;
        padding: var(--space-6);
    }

    .slide-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: var(--space-4);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }

    .slide-description {
        font-size: 1.125rem;
        opacity: 0.9;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
    }

    /* Navigation arrows */
    .slide-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: var(--space-3) var(--space-4);
        text-decoration: none;
        font-size: 1.5rem;
        border-radius: var(--radius);
        cursor: pointer;
        transition: background 0.3s;
        z-index: 10;
    }

    .slide-nav:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .slide-nav.prev {
        left: var(--space-4);
    }

    .slide-nav.next {
        right: var(--space-4);
    }

    /* Dots indicator */
    .slide-dots {
        position: absolute;
        bottom: var(--space-4);
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: var(--space-2);
        z-index: 10;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background 0.3s;
    }

    .dot.active,
    .dot:hover {
        background: white;
    }

    /* Slideshow info styles */
    .slideshow-info {
        position: absolute;
        top: var(--space-4);
        right: var(--space-4);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius);
        font-size: 0.875rem;
        z-index: 10;
    }

    .slide-counter {
        font-weight: 500;
    }

    /* Instagram Section Styles */
    .instagram-section {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        position: relative;
        overflow: hidden;
    }

    .instagram-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="instagramPattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="%23e2e8f0" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23instagramPattern)"/></svg>');
        opacity: 0.5;
    }

    .instagram-section .section-title {
        background: linear-gradient(135deg, #E4405F 0%, #C13584 50%, #833AB4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-3);
    }

    .instagram-section .section-title i {
        background: linear-gradient(135deg, #E4405F 0%, #C13584 50%, #833AB4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.5rem;
    }

    .instagram-container {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: var(--space-8);
        margin-bottom: var(--space-12);
    }

    .instagram-embed-wrapper {
        background: white;
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        border: 1px solid var(--gray-200);
        transition: var(--transition-slow);
    }

    .instagram-embed-wrapper:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .instagram-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-6);
        background: linear-gradient(135deg, #E4405F 0%, #C13584 50%, #833AB4 100%);
        color: white;
    }

    .instagram-profile {
        display: flex;
        align-items: center;
        gap: var(--space-4);
    }

    .profile-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .profile-info h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: var(--space-1);
        color: white;
    }

    .profile-info p {
        font-size: 0.875rem;
        opacity: 0.9;
        color: white;
    }

    .follow-btn {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-6);
        background: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        transition: var(--transition);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .follow-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .instagram-feed {
        position: relative;
        background: white;
        overflow: hidden;
        border-radius: 0 0 var(--radius-2xl) var(--radius-2xl);
    }

    .scroll-indicator {
        position: absolute;
        top: var(--space-4);
        right: var(--space-4);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: 0.75rem;
        color: var(--gray-600);
        z-index: 10;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: bounce 2s infinite;
        transition: all 0.3s ease;
        opacity: 1;
        transform: translateY(0);
    }

    .scroll-indicator i {
        color: var(--primary);
        font-size: 0.875rem;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-4px);
        }

        60% {
            transform: translateY(-2px);
        }
    }

    .instagram-iframe {
        border: none;
        border-radius: 0;
        display: block;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Custom scrollbar for Instagram iframe */
    .instagram-iframe::-webkit-scrollbar {
        width: 8px;
    }

    .instagram-iframe::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }

    .instagram-iframe::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #E4405F 0%, #C13584 50%, #833AB4 100%);
        border-radius: 4px;
    }

    .instagram-iframe::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #C13584 0%, #833AB4 50%, #E4405F 100%);
    }

    .instagram-highlights {
        display: flex;
        flex-direction: column;
        gap: var(--space-6);
    }

    .highlight-card {
        background: white;
        padding: var(--space-6);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
        transition: var(--transition-slow);
        text-align: center;
    }

    .highlight-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .highlight-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #E4405F 0%, #C13584 50%, #833AB4 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--space-4);
        font-size: 2rem;
        color: white;
        box-shadow: var(--shadow-md);
    }

    .highlight-card h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: var(--space-3);
    }

    .highlight-card p {
        color: var(--gray-600);
        line-height: 1.6;
    }

    .instagram-cta {
        background: linear-gradient(135deg, #E4405F 0%, #C13584 50%, #833AB4 100%);
        border-radius: var(--radius-2xl);
        padding: var(--space-12);
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .instagram-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="ctaPattern" width="30" height="30" patternUnits="userSpaceOnUse"><circle cx="15" cy="15" r="2" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23ctaPattern)"/></svg>');
        opacity: 0.3;
    }

    .cta-content {
        position: relative;
        z-index: 1;
    }

    .instagram-cta h3 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: var(--space-4);
        color: white;
    }

    .instagram-cta p {
        font-size: 1.125rem;
        margin-bottom: var(--space-8);
        opacity: 0.9;
        color: white;
    }

    .cta-buttons {
        display: flex;
        gap: var(--space-4);
        justify-content: center;
        flex-wrap: wrap;
    }

    .cta-buttons .btn {
        min-width: 200px;
    }

    .cta-buttons .btn-primary {
        background: white;
        color: #E4405F;
        border: 2px solid white;
    }

    .cta-buttons .btn-primary:hover {
        background: transparent;
        color: white;
        border-color: white;
    }

    .cta-buttons .btn-secondary {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .cta-buttons .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
        color: white;
    }

    /* Hero fallback styles */
    .hero-fallback {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        text-align: center;
        padding: var(--space-16) var(--space-4);
    }

    .hero-fallback .hero-content h1 {
        color: white;
        margin-bottom: var(--space-6);
    }

    .hero-fallback .hero-content p {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: var(--space-8);
    }

    /* About Section Styles */
    .about-section-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-16);
        align-items: start;
    }

    .about-content {
        display: flex;
        flex-direction: column;
        gap: var(--space-8);
    }

    .about-title {
        text-align: left;
        margin-bottom: 0;
    }

    .about-description {
        font-size: 1.125rem;
        color: var(--gray-600);
        line-height: 1.7;
        margin: 0;
    }

    .features-grid {
        display: grid;
        gap: var(--space-4);
    }

    .feature-card {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        background: var(--gray-50);
        border-radius: var(--radius-lg);
        transition: var(--transition);
    }

    .feature-card:hover {
        background: var(--gray-100);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .feature-icon-primary {
        background: var(--primary);
    }

    .feature-icon-accent {
        background: var(--accent);
    }

    .feature-icon-success {
        background: var(--success);
    }

    .feature-content {
        flex: 1;
    }

    .feature-title {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
        font-size: 1rem;
    }

    .feature-description {
        color: var(--gray-600);
        font-size: 0.875rem;
        margin: 0;
    }

    .concerts-card {
        position: sticky;
        top: calc(5rem + var(--space-4));
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .concerts-list {
        display: grid;
        gap: var(--space-6);
    }

    .concert-item {
        border-left: 4px solid var(--primary);
        padding-left: var(--space-4);
    }

    .concert-title {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: var(--space-1);
        font-size: 1rem;
    }

    .concert-date,
    .concert-venue {
        color: var(--gray-600);
        font-size: 0.875rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .concert-date {
        margin-bottom: var(--space-1);
    }

    .concert-date i,
    .concert-venue i {
        color: var(--accent);
        width: 16px;
    }

    .no-concerts {
        text-align: center;
        padding: var(--space-8);
        color: var(--gray-500);
    }

    .no-concerts i {
        font-size: 3rem;
        margin-bottom: var(--space-4);
        opacity: 0.3;
    }

    .concerts-btn {
        width: 100%;
    }

    @media (max-width: 768px) {
        .photo-slideshow {
            height: 300px;
        }

        .slide-title {
            font-size: 1.75rem;
        }

        .slide-description {
            font-size: 1rem;
        }

        .slide-nav {
            padding: var(--space-2) var(--space-3);
            font-size: 1.25rem;
        }

        /* Instagram Section Responsive */
        .instagram-container {
            grid-template-columns: 1fr;
            gap: var(--space-6);
        }

        .instagram-highlights {
            flex-direction: row;
            gap: var(--space-4);
        }

        .highlight-card {
            padding: var(--space-4);
        }

        .highlight-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .instagram-cta {
            padding: var(--space-8);
        }

        .instagram-cta h3 {
            font-size: 1.5rem;
        }

        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .cta-buttons .btn {
            width: 100%;
            max-width: 300px;
        }

        /* About Section Responsive */
        .about-section-grid {
            grid-template-columns: 1fr;
            gap: var(--space-12);
        }

        .about-content {
            gap: var(--space-6);
        }

        .about-title {
            text-align: center;
            font-size: 2rem;
        }

        .about-description {
            font-size: 1rem;
            text-align: center;
        }

        .features-grid {
            gap: var(--space-3);
        }

        .feature-card {
            padding: var(--space-3);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
        }

        .feature-title {
            font-size: 0.9rem;
        }

        .feature-description {
            font-size: 0.8rem;
        }

        .concerts-card {
            position: static;
        }

        .card-title {
            font-size: 1.125rem;
        }

        .concert-title {
            font-size: 0.9rem;
        }

        .concert-date,
        .concert-venue {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .instagram-highlights {
            flex-direction: column;
            gap: var(--space-3);
        }

        .highlight-card {
            padding: var(--space-3);
        }

        .highlight-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        .instagram-cta {
            padding: var(--space-6);
        }

        .instagram-cta h3 {
            font-size: 1.25rem;
        }

        .instagram-cta p {
            font-size: 1rem;
        }

        .instagram-header {
            flex-direction: column;
            gap: var(--space-4);
            text-align: center;
        }

        .instagram-profile {
            justify-content: center;
        }

        .profile-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        .profile-info h3 {
            font-size: 1.125rem;
        }

        .follow-btn {
            padding: var(--space-2) var(--space-4);
            font-size: 0.875rem;
        }

        .scroll-indicator {
            top: var(--space-2);
            right: var(--space-2);
            padding: var(--space-1) var(--space-2);
            font-size: 0.625rem;
        }

        .scroll-indicator span {
            display: none;
        }

        .scroll-indicator i {
            font-size: 0.75rem;
        }

        /* About Section Mobile Responsive */
        .about-section-grid {
            gap: var(--space-8);
        }

        .about-title {
            font-size: 1.75rem;
        }

        .about-description {
            font-size: 0.9rem;
        }

        .features-grid {
            gap: var(--space-2);
        }

        .feature-card {
            padding: var(--space-2);
            gap: var(--space-3);
        }

        .feature-icon {
            width: 36px;
            height: 36px;
        }

        .feature-title {
            font-size: 0.85rem;
        }

        .feature-description {
            font-size: 0.75rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .concert-title {
            font-size: 0.85rem;
        }

        .concert-date,
        .concert-venue {
            font-size: 0.75rem;
        }

        .no-concerts i {
            font-size: 2rem;
        }
    }
</style>

<script>
    let currentSlideIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Show current slide
        if (slides[index]) {
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }
    }

    function changeSlide(direction) {
        currentSlideIndex += direction;

        if (currentSlideIndex >= slides.length) {
            currentSlideIndex = 0;
        } else if (currentSlideIndex < 0) {
            currentSlideIndex = slides.length - 1;
        }

        showSlide(currentSlideIndex);
    }

    function currentSlide(index) {
        currentSlideIndex = index - 1;
        showSlide(currentSlideIndex);
    }

    // Auto-advance slides every 5 seconds
    setInterval(() => {
        changeSlide(1);
    }, 5000);

    // Initialize first slide
    document.addEventListener('DOMContentLoaded', function() {
        showSlide(0);

        // Hide scroll indicator after user interaction
        const scrollIndicator = document.querySelector('.scroll-indicator');
        const instagramIframe = document.querySelector('.instagram-iframe');

        if (scrollIndicator && instagramIframe) {
            // Hide indicator after 5 seconds
            setTimeout(() => {
                scrollIndicator.style.opacity = '0';
                scrollIndicator.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    scrollIndicator.style.display = 'none';
                }, 300);
            }, 5000);

            // Hide indicator when iframe is clicked/touched
            instagramIframe.addEventListener('click', () => {
                scrollIndicator.style.opacity = '0';
                scrollIndicator.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    scrollIndicator.style.display = 'none';
                }, 300);
            });
        }
    });
</script>
@endsection