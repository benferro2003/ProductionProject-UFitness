<!-- Navbar - code from bootstrap -->
<!-- link - https://getbootstrap.com/docs/4.0/components/navbar/ -->
<br>
<div class = "container">
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <!--Show logo in Nav Bar -->
    <img src="{{ asset('Dumbbell.png') }}" width="100" height="100" alt="Logo" class="navbar-brand">
    <button style="background-color: #34495e; box-shadow: 2px 2px;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" style = "color: white; font-size: 30px;" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style = "color: white; font-size: 30px;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Calculators
          </a>
          <!--Drop down menu for calculators-->
          <ul class="dropdown-menu" style="font-size: 20px;">
            <!--When calculator clicked calculator controller function used -->
            <li><a class="dropdown-item" href="{{ route('calculator.show', 'calorie') }}">Calorie Calculator</a></li>
            <li><a class="dropdown-item" href="{{ route('calculator.show', 'one_rep_max') }}">1RM Calculator</a></li>
            <li><a class="dropdown-item" href="{{ route('calculator.show', 'bmi') }}">BMI Calculator</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style = "color: white; font-size: 30px;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Workouts
          </a>
          <ul class="dropdown-menu" style = "font-size: 20px;">
            <li><a class="dropdown-item" href="{{ route('workouts.show') }}">My Workouts</a></li>
            <li><a class="dropdown-item" href="{{ route('generator.show') }}">Workout Generator</a></li>
          </ul>
        </li>
      </ul>

      <!--Right side of Nav Bar-->
      <!--Authentication allows users to login/register/log out -->
      <ul class="navbar-nav ms-auto" style="font-size: 30px;">
        @auth
      <li class="nav-item dropdown" style="font-size: 30px;">
        <a class="nav-link dropdown-toggle" style = "color: white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ asset('Dumbbell.png') }}" alt="Profile" width="50" height="50" class="rounded-circle">
        {{ Str::ucfirst(Str::lower(Str::substr(Auth::user()->name, 0))) }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <hr class="dropdown-divider">
        </li>
        <li style="font-size: 20px;">
          <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item";">Logout</button>
          </form>
        </li>
        </ul>
      </li>
    @else
    <li class="nav-item">
      <a class="nav-link" style = "color: white" href="{{ route('login') }}">Login</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" style = "color: white" href="{{ route('register') }}">Register</a>
    </li>
  @endauth
      </ul>

    </div>
  </div>
</nav>
<br>
</div>
