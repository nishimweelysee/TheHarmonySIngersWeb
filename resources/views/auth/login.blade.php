<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
    <div class="success-message">
        <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" placeholder="Enter your email" />
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" required
                autocomplete="current-password" placeholder="Enter your password" />
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <div class="checkbox-container">
                <input id="remember_me" type="checkbox" class="checkbox" name="remember">
                <label for="remember_me" style="color: var(--gray-600); font-size: 0.875rem;">Remember me</label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>
                Sign In
            </button>
        </div>

        <!-- Links -->
        <div style="text-align: center; margin-top: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.875rem;">
                @if (Route::has('register'))
                <div>
                    Don't have an account?
                    <a href="{{ route('register') }}" class="link">Create one here</a>
                </div>
                @endif

                @if (Route::has('password.request'))
                <div>
                    <a href="{{ route('password.request') }}" class="link">
                        <i class="fas fa-key" style="margin-right: 0.25rem;"></i>
                        Forgot your password?
                    </a>
                </div>
                @endif
            </div>
        </div>
    </form>
</x-guest-layout>