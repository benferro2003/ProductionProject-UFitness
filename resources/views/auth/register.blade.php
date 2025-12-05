<x-guest-layout>

<div class="auth-container">

    {{-- LEFT HERO SECTION (same as login) --}}
    <div class="auth-left">
        <div class="auth-left-inner">
            <h1 class="auth-title">Join UFIT</h1>

            <p class="auth-subtitle">
                Create your personal fitness account.<br>
                Start tracking workouts and achieving your goals.
            </p>

            <ul class="auth-benefits">
                <li>• Smart workout generator tailored to your lifestyle</li>
                <li>• Visual progress tracking for workouts & weight</li>
                <li>• Built-in calculators for calories, BMI & 1RM</li>
            </ul>
        </div>
    </div>

    {{-- RIGHT REGISTER PANEL --}}
    <div class="auth-right">
        <div class="auth-card">

            <h2 class="auth-card-title mb-4">Create Account</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input 
                        id="name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input 
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input 
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input 
                        id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Submit Button --}}
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- Already Registered --}}
            <div class="mt-5 text-center">
                <p class="text-gray-600 mb-2">Already have an account?</p>
                <x-primary-button>
                    <a href="{{ route('login') }}" class="auth-register-link">
                        Log In
                    </a>
                </x-primary-button>
            </div>

        </div>
    </div>

</div>

</x-guest-layout>
