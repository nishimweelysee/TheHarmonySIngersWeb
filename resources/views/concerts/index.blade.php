@extends('layouts.public')

@section('title', 'Concerts')
@section('description', 'Upcoming and past concerts by The Harmony Singers choir')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Our Concerts</h1>
        <p>
            Experience the magic of live choral music with The Harmony Singers.
            Join us for unforgettable performances that showcase our passion for musical excellence.
        </p>
    </div>
</section>

<!-- Upcoming Concerts -->
@if($upcomingConcerts->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Upcoming Concerts</h2>
            <p class="section-subtitle">
                Don't miss these exciting upcoming performances
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: var(--space-8);">
            @foreach($upcomingConcerts as $concert)
            <div class="card">
                @if($concert->featured_image)
                <img src="{{ asset('storage/' . $concert->featured_image) }}" alt="{{ $concert->title }}"
                    style="width: 100%; height: 250px; object-fit: cover;">
                @else
                <div
                    style="width: 100%; height: 250px; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-music" style="font-size: 4rem; color: white; opacity: 0.8;"></i>
                </div>
                @endif

                <div class="card-body">
                    <h3
                        style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--space-4);">
                        {{ $concert->title }}
                    </h3>
                    <p style="color: var(--gray-600); margin-bottom: var(--space-6); line-height: 1.6;">
                        {{ Str::limit($concert->description, 120) }}
                    </p>

                    <div style="display: grid; gap: var(--space-3); margin-bottom: var(--space-6);">
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div
                                style="width: 36px; height: 36px; background: var(--gray-100); border-radius: var(--radius); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-alt" style="color: var(--primary);"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">
                                    {{ $concert->date->format('F j, Y') }}
                                </div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">
                                    {{ $concert->date->format('g:i A') }}
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div
                                style="width: 36px; height: 36px; background: var(--gray-100); border-radius: var(--radius); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-map-marker-alt" style="color: var(--accent);"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">{{ $concert->venue }}</div>
                                @if($concert->venue_address)
                                <div style="font-size: 0.875rem; color: var(--gray-500);">{{ $concert->venue_address }}
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($concert->ticket_price)
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div
                                style="width: 36px; height: 36px; background: var(--gray-100); border-radius: var(--radius); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-ticket-alt" style="color: var(--success);"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">
                                    ${{ number_format($concert->ticket_price, 2) }}</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Per ticket</div>
                            </div>
                        </div>
                        @else
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <div
                                style="width: 36px; height: 36px; background: var(--success); border-radius: var(--radius); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="color: white;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--success);">Free Admission</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">No ticket required</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('concerts.show', $concert) }}" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-info-circle"></i>
                        Learn More & Get Tickets
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="section">
    <div class="container" style="text-align: center;">
        <div style="max-width: 500px; margin: 0 auto; padding: var(--space-16) 0;">
            <i class="fas fa-music" style="font-size: 5rem; color: var(--gray-300); margin-bottom: var(--space-6);"></i>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-700); margin-bottom: var(--space-4);">
                No Upcoming Concerts
            </h3>
            <p style="color: var(--gray-500); margin-bottom: var(--space-8);">
                We're working on scheduling our next performances. Check back soon or contact us for updates!
            </p>
            <a href="{{ route('contact.index') }}" class="btn btn-primary">
                <i class="fas fa-envelope"></i>
                Get Updates
            </a>
        </div>
    </div>
</section>
@endif

<!-- Past Concerts -->
@if($pastConcerts->count() > 0)
<section class="section" style="background: var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Past Performances</h2>
            <p class="section-subtitle">
                Celebrating our musical journey and memorable performances
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-6);">
            @foreach($pastConcerts as $concert)
            <div class="card">
                <div class="card-body">
                    <h3 style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-3);">
                        {{ $concert->title }}
                    </h3>
                    <div
                        style="display: flex; align-items: center; gap: var(--space-2); color: var(--gray-500); margin-bottom: var(--space-2);">
                        <i class="fas fa-calendar-alt"></i>
                        <span>
                            @if($concert->date)
                            {{ $concert->date->format('F j, Y') }}
                            @else
                            Date TBA
                            @endif
                        </span>
                    </div>
                    <div
                        style="display: flex; align-items: center; gap: var(--space-2); color: var(--gray-500); margin-bottom: var(--space-4);">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $concert->venue }}</span>
                    </div>
                    @if($concert->description)
                    <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.5;">
                        {{ Str::limit($concert->description, 100) }}
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="section"
    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white;">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: var(--space-6); color: white;">
            Want to Attend Our Next Concert?
        </h2>
        <p
            style="font-size: 1.25rem; margin-bottom: var(--space-8); opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
            Stay updated on our upcoming performances and special events. Contact us for ticket information and group
            rates.
        </p>
        <a href="{{ route('contact.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-envelope"></i>
            Get in Touch
        </a>
    </div>
</section>
@endsection