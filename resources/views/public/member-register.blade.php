@extends('layouts.public')

@section('title', 'Join The Harmony Singers Choir')

@section('content')
<style>
/* Modern Registration Page Styles */
.registration-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #173478 0%, #1e40af 50%, #3b82f6 100%);
    z-index: 1;
}

.hero-slideshow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    opacity: 0.3;
}

.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0;
    transition: opacity 3s ease-in-out;
}

.hero-slide.active {
    opacity: 1;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(23, 52, 120, 0.7);
    z-index: 3;
}

.floating-notes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    pointer-events: none;
    overflow: hidden;
}

.note {
    position: absolute;
    color: rgba(255, 255, 255, 0.1);
    font-size: 2rem;
    animation: float 6s ease-in-out infinite;
}

.note:nth-child(1) {
    left: 10%;
    animation-delay: 0s;
}

.note:nth-child(2) {
    left: 20%;
    animation-delay: 1s;
}

.note:nth-child(3) {
    left: 30%;
    animation-delay: 2s;
}

.note:nth-child(4) {
    left: 40%;
    animation-delay: 3s;
}

.note:nth-child(5) {
    left: 50%;
    animation-delay: 4s;
}

.note:nth-child(6) {
    left: 60%;
    animation-delay: 5s;
}

.note:nth-child(7) {
    left: 70%;
    animation-delay: 1.5s;
}

.note:nth-child(8) {
    left: 80%;
    animation-delay: 2.5s;
}

.note:nth-child(9) {
    left: 90%;
    animation-delay: 3.5s;
}

@keyframes float {

    0%,
    100% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
    }

    10% {
        opacity: 0.1;
    }

    90% {
        opacity: 0.1;
    }

    50% {
        transform: translateY(-10vh) rotate(180deg);
        opacity: 0.2;
    }
}

.registration-content {
    position: relative;
    z-index: 4;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.registration-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.registration-info {
    color: white;
    text-align: left;
}

.registration-info h1 {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.registration-info p {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    line-height: 1.6;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 2rem 0;
}

.features-list li {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.features-list li i {
    margin-right: 1rem;
    color: #60a5fa;
    font-size: 1.25rem;
}

.registration-form-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 2rem;
    padding: 3rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: slideInRight 0.8s ease-out;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.registration-info {
    animation: slideInLeft 0.8s ease-out;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.form-header p {
    color: #6b7280;
    font-size: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input.error {
    border-color: #ef4444;
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.submit-btn {
    width: 100%;
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 1rem;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
}

.login-link {
    text-align: center;
    margin-top: 1.5rem;
    color: #6b7280;
}

.login-link a {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
}

.login-link a:hover {
    text-decoration: underline;
}

.success-message {
    background: #d1fae5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 1rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

.success-message i {
    margin-right: 0.75rem;
    color: #10b981;
}

/* Responsive Design */
@media (max-width: 768px) {
    .registration-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .registration-info h1 {
        font-size: 2.5rem;
    }

    .registration-form-container {
        padding: 2rem;
    }

    .registration-content {
        padding: 1rem;
    }
}

@media (max-width: 480px) {
    .registration-info h1 {
        font-size: 2rem;
    }

    .registration-form-container {
        padding: 1.5rem;
    }
}

/* Phone Input with Country Code Styles */
.phone-input-container {
    display: flex;
    gap: 0.5rem;
    align-items: stretch;
}

.country-code-select {
    flex-shrink: 0;
    width: 120px;
    padding: 0.75rem 0.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    background: white;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.country-code-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.country-code-select:hover {
    border-color: #9ca3af;
}

.phone-number-input {
    flex: 1;
    min-width: 0;
}

/* Mobile responsive phone input */
@media (max-width: 640px) {
    .phone-input-container {
        flex-direction: column;
        gap: 0.5rem;
    }

    .country-code-select {
        width: 100%;
        order: 1;
    }

    .phone-number-input {
        order: 2;
    }
}

/* Error state for country code select */
.country-code-select.error {
    border-color: #ef4444;
}

.country-code-select.error:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}
</style>

<div class="registration-hero">
    <!-- Background Slideshow -->
    <div class="hero-background"></div>

    @if($slideshowImages->count() > 0)
    <div class="hero-slideshow">
        @foreach($slideshowImages as $index => $image)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
            style="background-image: url('{{ asset('storage/' . $image->file_path) }}')">
        </div>
        @endforeach
    </div>
    @endif

    <!-- Floating Musical Notes -->
    <div class="floating-notes">
        <div class="note">♪</div>
        <div class="note">♫</div>
        <div class="note">♬</div>
        <div class="note">♩</div>
        <div class="note">♪</div>
        <div class="note">♫</div>
        <div class="note">♬</div>
        <div class="note">♩</div>
        <div class="note">♪</div>
    </div>

    <div class="hero-overlay"></div>

    <div class="registration-content">
        <div class="registration-grid">
            <!-- Left Side - Information -->
            <div class="registration-info">
                <h1>Join The Harmony Singers Choir</h1>
                <p>Become part of our musical family and create beautiful harmonies that touch hearts and inspire
                    communities.</p>

                <ul class="features-list">
                    <li><i class="fas fa-music"></i> Join a passionate community of singers</li>
                    <li><i class="fas fa-calendar-alt"></i> Participate in exciting performances</li>
                    <li><i class="fas fa-users"></i> Make lifelong friendships</li>
                    <li><i class="fas fa-heart"></i> Share the joy of music</li>
                </ul>
            </div>

            <!-- Right Side - Registration Form -->
            <div class="registration-form-container">
                <div class="form-header">
                    <h2>Start Your Journey</h2>
                    <p>Fill out the form below to become a member</p>
                </div>

                @if (session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('public.member-register.store') }}">
                    @csrf

                    <!-- First Name -->
                    <div class="form-group">
                        <label for="first_name" class="form-label">
                            First Name <span style="color: #ef4444;">*</span>
                        </label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}"
                            class="form-input @error('first_name') error @enderror" placeholder="Enter your first name"
                            required>
                        @error('first_name')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="last_name" class="form-label">
                            Last Name <span style="color: #ef4444;">*</span>
                        </label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}"
                            class="form-input @error('last_name') error @enderror" placeholder="Enter your last name"
                            required>
                        @error('last_name')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email Address <span style="color: #ef4444;">*</span>
                        </label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                            class="form-input @error('email') error @enderror" placeholder="Enter your email address"
                            required>
                        @error('email')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone" class="form-label">
                            Phone Number <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="phone-input-container">
                            <select id="country_code" name="country_code"
                                class="country-code-select @error('country_code') error @enderror">
                                <option value="+250" {{ old('country_code', '+250') == '+250' ? 'selected' : '' }}>🇷🇼
                                    +250</option>
                                <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                                <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>🇬🇧 +44
                                </option>
                                <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>🇫🇷 +33
                                </option>
                                <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>🇩🇪 +49
                                </option>
                                <option value="+86" {{ old('country_code') == '+86' ? 'selected' : '' }}>🇨🇳 +86
                                </option>
                                <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>🇮🇳 +91
                                </option>
                                <option value="+234" {{ old('country_code') == '+234' ? 'selected' : '' }}>🇳🇬 +234
                                </option>
                                <option value="+254" {{ old('country_code') == '+254' ? 'selected' : '' }}>🇰🇪 +254
                                </option>
                                <option value="+256" {{ old('country_code') == '+256' ? 'selected' : '' }}>🇺🇬 +256
                                </option>
                                <option value="+255" {{ old('country_code') == '+255' ? 'selected' : '' }}>🇹🇿 +255
                                </option>
                                <option value="+27" {{ old('country_code') == '+27' ? 'selected' : '' }}>🇿🇦 +27
                                </option>
                            </select>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                                class="form-input phone-number-input @error('phone') error @enderror"
                                placeholder="Enter your phone number" required>
                        </div>
                        @error('phone')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                        @error('country_code')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="form-group">
                        <label for="date_of_birth" class="form-label">
                            Date of Birth
                        </label>
                        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}"
                            class="form-input @error('date_of_birth') error @enderror">
                        @error('date_of_birth')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address" class="form-label">
                            Address
                        </label>
                        <textarea id="address" name="address" rows="3"
                            class="form-input @error('address') error @enderror"
                            placeholder="Enter your address (optional)">{{ old('address') }}</textarea>
                        @error('address')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-user-plus mr-2"></i>
                        Join The Harmony Singers Choir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Slideshow functionality
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length > 1) {
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Auto-advance slides every 4 seconds
        setInterval(nextSlide, 4000);
    }
});
</script>
@endsection