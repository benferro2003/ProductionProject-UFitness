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
    <h1 class="Title">LOG WORKOUT</h1>
</head>

<body class="background">
    <div class="card mt-5"
        style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
        <form action="{{ route('log.workout') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="form-control-lg">
                        <label class="form-label fw-bold" for="workout_name">Workout Name :</label>
                        <select class="form-select" name="workout_name" id="workout_name">
                            <option value="cardio">Cardio</option>
                            <option value="push">Push</option>
                            <option value="pull">Pull</option>
                            <option value="legs">Legs</option>
                            <option value="full body">Full Body</option>
                            <option value="upper">Upper Body</option>
                            <option value="lower">Lower Body</option>
                        </select>
                    </div>

                    <div class="form-control-lg">
                        <label class = "form-label fw-bold" for="duration">Duration (In minutes) :</label>
                        <input type="text" class="form-control" name="duration" id="duration" required>
                    </div><br>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-outline-light btn-lg">Log Workout</button>
                    </div>
                </div>
            </div><br>
        </form>
    </div><br><br>
</body>


<footer>
    <div class="card" style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
        <div class="centre">
            <a href="{{ route('weightLog.show') }}" class="btn btn-outline-light btn-lg btn-block left">LOG WEIGHT</a>
        </div>
    </div>
</footer>

</html>