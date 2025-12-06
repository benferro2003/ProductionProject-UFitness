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
    <title>Log Weight</title>
</head>

<body class="background">

    <div class="container mt-5">

        <h1 class="section-title text-center">Log Weight</h1>

        {{-- WEIGHT LOG FORM PANEL --}}
        <div class="panel mt-4">

            <form action="{{ route('log.weight') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 offset-md-3">

                        {{-- WEIGHT INPUT --}}
                        <div class="form-group mb-3">
                            <label class="fw-bold" for="weight">Weight (kg):</label>
                            <input type="text" class="form-control" name="weight" id="weight"
                                   value="{{ old('weight') }}" required>

                            @error('weight')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- GOAL SELECT --}}
                        <div class="form-group mb-3">
                            <label class="fw-bold" for="weight_goal">Goal:</label>
                            <select class="form-select" name="weight_goal" id="weight_goal">
                                <option value="" disabled selected>Select your goal</option>
                                <option value="loss">Weight Loss</option>
                                <option value="gain">Weight Gain</option>
                                <option value="maintain">Maintain Weight</option>
                            </select>

                            @error('weight_goal')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="ufit-btn w-100">Log Weight</button>
                        </div>

                    </div>
                </div>

            </form>

        </div>

        {{-- FOOTER CTA --}}
        <div class="panel mt-4 text-center">
            <a href="{{ route('activityLog.show') }}" class="ufit-btn w-100 py-2">Log Workout</a>
        </div>

    </div>

</body>

</html>
