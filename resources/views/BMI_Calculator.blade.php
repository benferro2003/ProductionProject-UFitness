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
        <h1 class="text-center">BMI Calculator</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <form action="POST" method="POST">
          @csrf
          <label for="Age">Age</label><br>
          <input type="text" name="age" id="age" class="form-control">

          <div class="form-group">
            <label for="sex">Sex</label>
            <select class="form-control" id="sex">
              <option></option>
              <option value = "male">Male</option>
              <option value = "female">Female</option>
            </select>
          </div>

            <label for="Weight">Weight (In kg)</label>
            <input type="text" name="weight" id="weight" class="form-control">

            <label for="Height">Height (In cm)</label>
            <input type="text" name="height" id="height" class="form-control">


           <br>

          <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
</body>