<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Full Name</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus
                autocomplete="name" placeholder="Enter your full name" />
            @error('name')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required
                autocomplete="username" placeholder="Enter your email address" />
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password"
                placeholder="Create a secure password" />
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Confirm your password" />
            @error('password_confirmation')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn-primary">
                <i class="fas fa-user-plus" style="margin-right: 0.5rem;"></i>
                Create Account
            </button>
        </div>

        <!-- Links -->
        <div style="text-align: center; margin-top: 1.5rem;">
            <div style="font-size: 0.875rem;">
                Already have an account?
                <a href="{{ route('login') }}" class="link">Sign in here</a>
            </div>
        </div>
    </form>
</x-guest-layout>