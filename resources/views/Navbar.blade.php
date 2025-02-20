<!-- Navbar - code from bootstrap -->
<!-- link - https://getbootstrap.com/docs/4.0/components/navbar/ -->
<nav class="navbar navbar-expand-lg custom-nav">
  <div class="container-fluid">
    <img src="Dumbbell.png" width="100" height="100" alt="Logo" class="navbar-brand">
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
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="CalorieCalculator">Calorie Calculator</a></li>
            <li><a class="dropdown-item" href="#">1RM Calculator</a></li>
            <li><a class="dropdown-item" href="#">BMI Calculator</a></li>
          </ul>
        </li>
      </ul>

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