<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  @include('Navbar')
  <title>BMI</title>
</head>

<body class="background">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="Title">BMI Calculator:</h>
      </div>
    </div>
    <div class="card mt-5"
      style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
      <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
          <form action="{{ route('calculator.calculate', 'bmi') }}" method="POST">
            @csrf

            <label for="Weight">Weight (In kg)</label>
            <input type="text" name="weight" id="weight" class="form-control" required>

            <label for="Height">Height (In cm)</label>
            <input type="text" name="height" id="height" class="form-control" required>


            <br>

            <button type="submit" class="btn btn-primary">Calculate</button>
          </form>
          @if(session('result'))
            @php
        $bmi_value = "";
        if (session('result') < 18.5) {
        $bmi_value = "Underweight";
        } elseif (session('result') >= 18.5 && session('result') < 24.9) {
        $bmi_value = "Normal weight";
        } elseif (session('result') >= 25 && session('result') < 29.9) {
        $bmi_value = "Overweight";
        } elseif (session('result') >= 30) {
        $bmi_value = "Obese";
        }
      @endphp

            <div class="alert alert-success mt-3">
            Your estimated BMI is {{ session('result') }} - {{$bmi_value}}<br>
            </div>
      @endif
        </div>
      </div>
    </div>
  </div>
</body>

</html>