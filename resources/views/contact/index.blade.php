@extends('layouts.public')

@section('title', 'Contact Us')
@section('description', 'Get in touch with The Harmony Singers choir for information about joining, concerts, or general
inquiries')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Contact Us</h1>
        <p>
            We'd love to hear from you! Reach out with any questions or to learn about joining our choir family.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-16); align-items: start;">

            <!-- Contact Form -->
            <div class="card">
                <div class="card-header">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900);">Send us a Message</h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div
                        style="background: var(--success); color: white; padding: var(--space-4); border-radius: var(--radius-lg); margin-bottom: var(--space-6);">
                        <i class="fas fa-check-circle" style="margin-right: var(--space-2);"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}"
                        style="display: grid; gap: var(--space-6);">
                        @csrf

                        <div>
                            <label for="name"
                                style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--space-2);">
                                Full Name
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                style="width: 100%; padding: var(--space-3); border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(23, 52, 120, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            @error('name')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: var(--space-1);">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="email"
                                style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--space-2);">
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                style="width: 100%; padding: var(--space-3); border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 1rem; transition: var(--transition);"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(23, 52, 120, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            @error('email')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: var(--space-1);">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject"
                                style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--space-2);">
                                Subject
                            </label>
                            <select id="subject" name="subject" required
                                style="width: 100%; padding: var(--space-3); border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 1rem; transition: var(--transition); background: white;"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(23, 52, 120, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                <option value="">Select a subject</option>
                                <option value="joining" {{ old('subject') === 'joining' ? 'selected' : '' }}>Joining the
                                    Choir</option>
                                <option value="concerts" {{ old('subject') === 'concerts' ? 'selected' : '' }}>Concert
                                    Information</option>
                                <option value="performances" {{ old('subject') === 'performances' ? 'selected' : '' }}>
                                    Booking Performances</option>
                                <option value="donations" {{ old('subject') === 'donations' ? 'selected' : '' }}>
                                    Donations & Sponsorship</option>
                                <option value="general" {{ old('subject') === 'general' ? 'selected' : '' }}>General
                                    Inquiry</option>
                            </select>
                            @error('subject')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: var(--space-1);">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="message"
                                style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--space-2);">
                                Message
                            </label>
                            <textarea id="message" name="message" rows="6" required
                                placeholder="Tell us how we can help you..."
                                style="width: 100%; padding: var(--space-3); border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 1rem; transition: var(--transition); resize: vertical; min-height: 120px;"
                                onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(23, 52, 120, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">{{ old('message') }}</textarea>
                            @error('message')
                            <p style="color: var(--error); font-size: 0.875rem; margin-top: var(--space-1);">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                            <i class="fas fa-paper-plane"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <div class="card" style="margin-bottom: var(--space-8);">
                    <div class="card-header">
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900);">Get in Touch</h2>
                    </div>

                    <div class="card-body">
                        <div style="display: grid; gap: var(--space-6);">
                            <div style="display: flex; align-items: start; gap: var(--space-4);">
                                <div
                                    style="width: 48px; height: 48px; background: var(--primary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-envelope" style="color: white;"></i>
                                </div>
                                <div>
                                    <h3
                                        style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1);">
                                        Email</h3>
                                    <p style="color: var(--gray-600); margin-bottom: var(--space-1);">
                                        info@harmonysingers.com</p>
                                    <p style="color: var(--gray-600);">director@harmonysingers.com</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: var(--space-4);">
                                <div
                                    style="width: 48px; height: 48px; background: var(--accent); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-phone" style="color: white;"></i>
                                </div>
                                <div>
                                    <h3
                                        style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1);">
                                        Phone</h3>
                                    <p style="color: var(--gray-600); margin-bottom: var(--space-1);">(250) 791334414
                                    </p>
                                    <p style="color: var(--gray-500); font-size: 0.875rem;">Monday - Friday, 9 AM - 6 PM
                                    </p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: var(--space-4);">
                                <div
                                    style="width: 48px; height: 48px; background: var(--success); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-map-marker-alt" style="color: white;"></i>
                                </div>
                                <div>
                                    <h3
                                        style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1);">
                                        Rehearsal Location</h3>
                                    <p style="color: var(--gray-600);">Kicukiro Kagarama SDA Church</p>
                                    <p style="color: var(--gray-600);">Kurusengero</p>
                                    <p style="color: var(--gray-600);">Munsi Y'isoko</p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: var(--space-4);">
                                <div
                                    style="width: 48px; height: 48px; background: var(--warning); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-clock" style="color: white;"></i>
                                </div>
                                <div>
                                    <h3
                                        style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-1);">
                                        Rehearsal Schedule</h3>
                                    <p style="color: var(--gray-600); margin-bottom: var(--space-1);">Friday: 7:30 PM -
                                        20:30 PM</p>
                                    <p style="color: var(--gray-600); margin-bottom: var(--space-1);">Saturday: 15:00 PM
                                        - 18:00 PM</p>
                                    <p style="color: var(--gray-500); font-size: 0.875rem;">Additional rehearsals before
                                        concerts</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Join Us Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            <i class="fas fa-users" style="margin-right: var(--space-2); color: var(--primary);"></i>
                            Ready to Join?
                        </h3>
                    </div>
                    <div class="card-body">
                        <p style="color: var(--gray-600); margin-bottom: var(--space-4); line-height: 1.6;">
                            We welcome new members throughout the year! No audition required - just a love of music and
                            commitment to regular rehearsals.
                        </p>
                        <div
                            style="background: var(--gray-50); padding: var(--space-4); border-radius: var(--radius-lg); margin-bottom: var(--space-6);">
                            <h4 style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--space-3);">What
                                You Need to Know:</h4>
                            <ul style="list-style: none; padding: 0; display: grid; gap: var(--space-2);">
                                <li style="display: flex; align-items: center; gap: var(--space-2);">
                                    <i class="fas fa-check" style="color: var(--success);"></i>
                                    <span style="color: var(--gray-600);">All skill levels welcome</span>
                                </li>
                                <li style="display: flex; align-items: center; gap: var(--space-2);">
                                    <i class="fas fa-check" style="color: var(--success);"></i>
                                    <span style="color: var(--gray-600);">Music reading helpful but not required</span>
                                </li>
                                <li style="display: flex; align-items: center; gap: var(--space-2);">
                                    <i class="fas fa-check" style="color: var(--success);"></i>
                                    <span style="color: var(--gray-600);">Regular attendance expected</span>
                                </li>
                                <li style="display: flex; align-items: center; gap: var(--space-2);">
                                    <i class="fas fa-dollar-sign" style="color: var(--warning);"></i>
                                    <span style="color: var(--gray-600);">Annual membership fee: Free</span>
                                </li>
                            </ul>
                        </div>
                        <a href="#"
                            onclick="document.getElementById('subject').value='joining'; document.getElementById('subject').focus(); return false;"
                            class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-user-plus"></i>
                            Ask About Joining
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection