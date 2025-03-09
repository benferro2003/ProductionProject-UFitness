<!-- Navbar - code from bootstrap -->
<!-- link - https://getbootstrap.com/docs/4.0/components/navbar/ -->
<nav class="navbar navbar-expand-lg custom-nav">
  <div class="container-fluid">
    <!--Show logo in Nav Bar -->
    <img src="{{ asset('Dumbbell.png') }}" width="100" height="100" alt="Logo" class="navbar-brand">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Calculators
          </a>
          <!--Drop down menu for calculators-->
          <ul class="dropdown-menu">
            <!--When calculator clicked calculator controller function used -->
            <li><a class="dropdown-item" href="{{ route('calculator.show', 'calorie') }}">Calorie Calculator</a></li>
            <li><a class="dropdown-item" href="{{ route('calculator.show', 'one_rep_max') }}">1RM Calculator</a></li>
            <li><a class="dropdown-item" href="{{ route('calculator.show', 'bmi') }}">BMI Calculator</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Workouts
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="">My Workouts</a></li>
            <li><a class="dropdown-item" href="">Workout Generator</a></li>
          </ul>
        </li>
      </ul>

      <!--Right side of Nav Bar-->
      <!--Authentication allows users to login/register/log out -->
      <ul class="navbar-nav ms-auto">
        @auth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ asset('Dumbbell.png') }}" alt="Profile" width="40" height="40" class="rounded-circle">
        {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <hr class="dropdown-divider">
        </li>
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