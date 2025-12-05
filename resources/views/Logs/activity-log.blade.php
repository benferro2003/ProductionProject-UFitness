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
    <title>Log Workout</title>
</head>

<body class="background">

    <div class="container mt-5">

        <h1 class="section-title text-center">Log Workout</h1>

        {{-- LOG WORKOUT FORM PANEL --}}
        <div class="panel mt-4">

            <form action="{{ route('log.workout') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 offset-md-3">

                        {{-- Workout Name --}}
                        <div class="form-group mb-3">
                            <label class="fw-bold" for="workout_name">Workout Name:</label>
                            <select class="form-select" name="workout_name" id="workout_name">
                                <option value="cardio">Cardio</option>
                                <option value="push">Push</option>
                                <option value="pull">Pull</option>
                                <option value="legs">Legs</option>
                                <option value="full body">Full Body</option>
                                <option value="upper">Upper Body</option>
                                <option value="lower">Lower Body</option>
                            </select>
                            @error('workout_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Duration --}}
                        <div class="form-group mb-3">
                            <label class="fw-bold" for="duration">Duration (minutes):</label>
                            <input type="text" class="form-control" name="duration" id="duration"
                                   value="{{ old('duration') }}" required>
                            @error('duration')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="ufit-btn w-100">Log Workout</button>
                        </div>

                    </div>
                </div>

            </form>

        </div>

        {{-- FOOTER CTA --}}
        <div class="panel mt-4 text-center">
            <a href="{{ route('weightLog.show') }}" class="ufit-btn w-100 py-2">Log Weight</a>
        </div>

    </div>

</body>

</html>
