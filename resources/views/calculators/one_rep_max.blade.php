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
  <title>1RM</title>
</head>

<body class="background">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="Title">One Rep Max Calculator:</h1>
      </div>
    </div>
    <div class="card mt-5"
      style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
      <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
          <form action="{{ route('calculator.calculate', 'one_rep_max') }}" method="POST">
            @csrf
            <label for="max_weight">Weight (In kg)</label>
            <input type="text" name="max_weight" id="max_weight" class="form-control" value="{{ old('max_weight') }}" required>
            @error('max_weight')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label for="reps">Number of Repetitions</label>
            <input type="text" name="reps" id="reps" class="form-control" value="{{ old(key: 'reps') }}" required>
            @error('reps')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <br>

            <button type="submit" class="btn btn-primary">Calculate</button>
          </form>

          @if(session('result'))
        <div class="alert alert-success mt-3">
        Your estimated 1RM is: {{ session('result') }} kg
        </div>
      @endif
        </div>
      </div>
    </div>
  </div>
</body>

</html>