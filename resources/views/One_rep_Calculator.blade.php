<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<header>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  @include('Navbar')
</header>

<body class="background">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">One Rep Max Calculator</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <form action="POST" method="POST">
          @csrf
            <label for="max_weight">Weight (In kg)</label>
            <input type="text" name="max_weight" id="max_weight" class="form-control">

            <label for="reps">Number of Repetitions</label>
            <input type="text" name="reps" id="reps" class="form-control">


           <br>

          <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
</body>