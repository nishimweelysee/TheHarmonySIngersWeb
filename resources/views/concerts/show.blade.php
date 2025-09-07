@extends('layouts.public')

@section('title', $concert->title)
@section('description', $concert->description ? Str::limit($concert->description, 160) : 'Join us for ' . $concert->title)

@section('content')
<!-- Concert Header -->
<section class="concert-header" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; padding: var(--space-16) 0;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: var(--space-6); line-height: 1.2;">
                {{ $concert->title }}
            </h1>
            @if($concert->description)
            <p style="font-size: 1.25rem; margin-bottom: var(--space-8); opacity: 0.9; line-height: 1.6;">
                {{ $concert->description }}
            </p>
            @endif

            <!-- Concert Meta Info -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-6); margin-bottom: var(--space-8);">
                @if($concert->date)
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700; margin-bottom: var(--space-2);">
                        {{ $concert->date->format('j') }}
                    </div>
                    <div style="font-size: 1rem; opacity: 0.8;">
                        {{ $concert->date->format('F Y') }}
                    </div>
                    <div style="font-size: 0.875rem; opacity: 0.7; margin-top: var(--space-1);">
                        {{ $concert->date->format('g:i A') }}
                    </div>
                </div>
                @endif

                @if($concert->venue)
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-2);">
                        <i class="fas fa-map-marker-alt" style="margin-right: var(--space-2);"></i>
                        Venue
                    </div>
                    <div style="font-size: 1rem; opacity: 0.8;">
                        {{ $concert->venue }}
                    </div>
                    @if($concert->venue_address)
                    <div style="font-size: 0.875rem; opacity: 0.7; margin-top: var(--space-1);">
                        {{ $concert->venue_address }}
                    </div>
                    @endif
                </div>
                @endif

                @if($concert->ticket_price)
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-2);">
                        <i class="fas fa-ticket-alt" style="margin-right: var(--space-2);"></i>
                        Tickets
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--accent);">
                        ${{ number_format($concert->ticket_price, 2) }}
                    </div>
                    <div style="font-size: 0.875rem; opacity: 0.7; margin-top: var(--space-1);">
                        Per ticket
                    </div>
                </div>
                @else
                <div style="text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-2);">
                        <i class="fas fa-check-circle" style="margin-right: var(--space-2);"></i>
                        Admission
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">
                        FREE
                    </div>
                    <div style="font-size: 0.875rem; opacity: 0.7; margin-top: var(--space-1);">
                        No ticket required
                    </div>
                </div>
                @endif
            </div>

            <!-- Call to Action -->
            <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
                @if($concert->ticket_price)
                <a href="{{ route('contact.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-ticket-alt"></i>
                    Get Tickets
                </a>
                @endif
                <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-envelope"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Concert Details -->
<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: var(--space-12);">
            <!-- Main Content -->
            <div>
                @if($concert->description)
                <div style="margin-bottom: var(--space-8);">
                    <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: var(--space-4); color: var(--gray-900);">
                        About This Concert
                    </h2>
                    <div style="color: var(--gray-700); line-height: 1.7; font-size: 1.125rem;">
                        {!! nl2br(e($concert->description)) !!}
                    </div>
                </div>
                @endif

                @if($concert->program_notes)
                <div style="margin-bottom: var(--space-8);">
                    <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: var(--space-4); color: var(--gray-900);">
                        Program Notes
                    </h2>
                    <div style="color: var(--gray-700); line-height: 1.7; font-size: 1.125rem;">
                        {!! nl2br(e($concert->program_notes)) !!}
                    </div>
                </div>
                @endif

                @if($concert->media && $concert->media->count() > 0)
                <div>
                    <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: var(--space-4); color: var(--gray-900);">
                        Concert Media
                    </h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-4);">
                        @foreach($concert->media as $media)
                        <div class="card">
                            @if($media->type === 'photo')
                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}"
                                style="width: 100%; height: 200px; object-fit: cover;">
                            @elseif($media->type === 'video')
                            <div style="width: 100%; height: 200px; background: var(--gray-800); display: flex; align-items: center; justify-content: center; position: relative;">
                                <i class="fas fa-play-circle" style="font-size: 4rem; color: white; opacity: 0.8;"></i>
                            </div>
                            @else
                            <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-music" style="font-size: 4rem; color: white; opacity: 0.8;"></i>
                            </div>
                            @endif
                            <div class="card-body">
                                <h3 style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-2);">{{ $media->title }}</h3>
                                @if($media->description)
                                <p style="color: var(--gray-600); font-size: 0.875rem;">{{ Str::limit($media->description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Concert Info Card -->
                <div class="card" style="margin-bottom: var(--space-6);">
                    <div class="card-header">
                        <h3 style="font-weight: 600; color: var(--gray-900);">Concert Information</h3>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; gap: var(--space-4);">
                            @if($concert->date)
                            <div style="display: flex; align-items: center; gap: var(--space-3);">
                                <div style="width: 40px; height: 40px; background: var(--primary); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; color: white;">
                                    <i class="fas fa-calendar-alt"></i>
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
                            @endif

                            @if($concert->venue)
                            <div style="display: flex; align-items: center; gap: var(--space-3);">
                                <div style="width: 40px; height: 40px; background: var(--accent); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; color: white;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">{{ $concert->venue }}</div>
                                    @if($concert->venue_address)
                                    <div style="font-size: 0.875rem; color: var(--gray-500);">{{ $concert->venue_address }}</div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($concert->type)
                            <div style="display: flex; align-items: center; gap: var(--space-3);">
                                <div style="width: 40px; height: 40px; background: var(--success); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; color: white;">
                                    <i class="fas fa-music"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">{{ ucfirst($concert->type) }}</div>
                                    <div style="font-size: 0.875rem; color: var(--gray-500);">Concert Type</div>
                                </div>
                            </div>
                            @endif

                            @if($concert->capacity)
                            <div style="display: flex; align-items: center; gap: var(--space-3);">
                                <div style="width: 40px; height: 40px; background: var(--warning); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; color: white;">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">{{ number_format($concert->capacity) }}</div>
                                    <div style="font-size: 0.875rem; color: var(--gray-500);">Seating Capacity</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="font-weight: 600; color: var(--gray-900);">Get in Touch</h3>
                    </div>
                    <div class="card-body">
                        <p style="color: var(--gray-600); margin-bottom: var(--space-4);">
                            Have questions about this concert? Need tickets or want to know more?
                        </p>
                        <a href="{{ route('contact.index') }}" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-envelope"></i>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Concerts -->
@if($relatedConcerts && $relatedConcerts->count() > 0)
<section class="section" style="background: var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Other Upcoming Concerts</h2>
            <p class="section-subtitle">Don't miss our other performances</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-6);">
            @foreach($relatedConcerts as $relatedConcert)
            <div class="card">
                <div class="card-body">
                    <h3 style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-3);">
                        {{ $relatedConcert->title }}
                    </h3>
                    @if($relatedConcert->date)
                    <div style="display: flex; align-items: center; gap: var(--space-2); color: var(--gray-500); margin-bottom: var(--space-2);">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $relatedConcert->date->format('F j, Y') }}</span>
                    </div>
                    @endif
                    @if($relatedConcert->venue)
                    <div style="display: flex; align-items: center; gap: var(--space-2); color: var(--gray-500); margin-bottom: var(--space-4);">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $relatedConcert->venue }}</span>
                    </div>
                    @endif
                    @if($relatedConcert->description)
                    <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.5; margin-bottom: var(--space-4);">
                        {{ Str::limit($relatedConcert->description, 100) }}
                    </p>
                    @endif
                    <a href="{{ route('concerts.show', $relatedConcert) }}" class="btn btn-secondary" style="width: 100%;">
                        <i class="fas fa-info-circle"></i>
                        Learn More
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="section" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white;">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: var(--space-6); color: white;">
            Ready to Experience Beautiful Music?
        </h2>
        <p style="font-size: 1.25rem; margin-bottom: var(--space-8); opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
            Join us for this special performance and be part of our musical journey.
        </p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('concerts.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-calendar"></i>
                View All Concerts
            </a>
            <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-envelope"></i>
                Get in Touch
            </a>
        </div>
    </div>
</section>
@endsection