<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}">-->
  @vite(['resources/css/app.css', 'resources/js/app.js
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

  @include('Navbar')
  <title>1RM</title>
</head>

<body class="background">

  <div class="container mt-5">

    <h1 class="section-title text-center">One Rep Max Calculator</h1>

    {{-- FORM PANEL --}}
    <div class="panel mt-4">

      <div class="row">
        <div class="col-md-6 offset-md-3">

          <form action="{{ route('calculator.calculate', 'one_rep_max') }}" method="POST">
            @csrf

            {{-- Weight --}}
            <label for="max_weight" class="fw-bold">Weight (kg)</label>
            <input type="text" name="max_weight" id="max_weight" class="form-control"
                   value="{{ old('max_weight') }}" required>
            @error('max_weight')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror

            {{-- Reps --}}
            <label for="reps" class="fw-bold mt-3">Number of Repetitions</label>
            <input type="text" name="reps" id="reps" class="form-control"
                   value="{{ old('reps') }}" required>
            @error('reps')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror

            {{-- Submit --}}
            <button type="submit" class="ufit-btn w-100 mt-4">Calculate</button>

          </form>

          {{-- RESULT --}}
          @if(session('result'))
            <div class="panel mt-4 text-center">
              <p class="subtitle fw-bold mb-1">Your estimated 1RM is:</p>
              <h2 class="fw-bold" style="color: var(--accent);">{{ session('result') }} kg</h2>
            </div>
          @endif

        </div>
      </div>

    </div>

  </div>

</body>

</html>
