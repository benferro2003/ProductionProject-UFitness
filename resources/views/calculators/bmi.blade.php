<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}">-->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

  @include('Navbar')
  <title>BMI</title>
</head>

<body class="background">

  <div class="container mt-5">

    <h1 class="section-title text-center">BMI Calculator</h1>

    {{-- FORM PANEL --}}
    <div class="panel mt-4">

      <div class="row">
        <div class="col-md-6 offset-md-3">

          <form action="{{ route('calculator.calculate', 'bmi') }}" method="POST">
            @csrf

            {{-- Weight --}}
            <label for="weight" class="fw-bold">Weight (kg)</label>
            <input type="text" name="weight" id="weight" class="form-control"
                   value="{{ old('weight') }}" required>
            @error('weight')
              <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror

            {{-- Height --}}
            <label for="height" class="fw-bold mt-3">Height (cm)</label>
            <input type="text" name="height" id="height" class="form-control"
                   value="{{ old('height') }}" required>
            @error('height')
              <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror

            {{-- Submit --}}
            <button type="submit" class="ufit-btn w-100 mt-4">Calculate</button>

          </form>

          {{-- RESULTS --}}
          @if(session('result'))
            @php
              // Determine BMI category
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

            <div class="panel mt-4 text-center">
              <p class="subtitle fw-bold mb-1">Your BMI Result</p>
              <h2 class="fw-bold" style="color: var(--accent);">
                {{ session('result') }} — {{ $bmi_value }}
              </h2>
            </div>
          @endif

        </div>
      </div>

    </div>

  </div>

</body>

</html>
