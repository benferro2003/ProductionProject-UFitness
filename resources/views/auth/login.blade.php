<x-guest-layout>
<!-- include css for login blade-->
<div class="auth-container">

    {{-- LEFT HERO SECTION --}}
    <div class="auth-left">
        <div class="auth-left-inner">

            <img src="/images/ufit-logo.svg" class="banner-icon" alt="UFIT Logo">
            <h1 class="auth-title">Welcome to UFIT</h1>

            <p class="auth-subtitle">
                Your personalised fitness companion.<br>
                Track workouts, monitor progress, and reach your goals.
            </p>

            <ul class="auth-benefits">
                <li>• Smart workout generator tailored to your lifestyle</li>
                <li>• Visual progress tracking for workouts & weight</li>
                <li>• Built-in calculators for calories, BMI & 1RM</li>
            </ul>
        </div>
    </div>

    {{-- RIGHT LOGIN PANEL --}}
    <div class="auth-right">
        <div class="auth-card">

            <h2 class="auth-card-title mb-4">Log In</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                                  type="email" name="email" :value="old('email')"
                                  required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                               name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="mt-5 text-center">
                <p class="text-gray-600 mb-2">New to UFIT?</p>
                <x-primary-button>
                    <a href="{{ route('register') }}" class="auth-register-link">
                        Create an Account
                    </a>
                </x-primary-button>
            </div>

        </div>
    </div>

</div>

</x-guest-layout>
