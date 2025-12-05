<nav class="navbar navbar-expand-lg custom-nav shadow-sm">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand" href="/">
            UFIT
        </a>

        {{-- Mobile Toggle --}}
        <button 
            class="navbar-toggler border-0 nav-toggle-btn" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">

            {{-- LEFT NAVIGATION --}}
            <ul class="navbar-nav">

                {{-- Calculators --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Calculators
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('calculator.show', 'calorie') }}">Calorie Calculator</a></li>
                        <li><a class="dropdown-item" href="{{ route('calculator.show', 'one_rep_max') }}">1RM Calculator</a></li>
                        <li><a class="dropdown-item" href="{{ route('calculator.show', 'bmi') }}">BMI Calculator</a></li>
                    </ul>
                </li>

                {{-- Workouts --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Workouts
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('workouts.show') }}">My Workouts</a></li>
                        <li><a class="dropdown-item" href="{{ route('generator.show') }}">Workout Generator</a></li>
                    </ul>
                </li>

            </ul>

            {{-- RIGHT SIDE AUTH --}}
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">

                          <img src="/images/ufit-logo.svg" class="hero-icon" alt="UFIT Logo">

                            {{ Str::ucfirst(Str::lower(Str::substr(Auth::user()->name, 0))) }}

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>
