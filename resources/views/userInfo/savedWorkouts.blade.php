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
    <title>My Workouts</title>
</head>

<body class="background">
    <div class="container mt-5">
        <h1 class="Title">My Workouts</h1>
        @if(count($savedWorkouts) > 0)
            <!-- need to output contents of savedWorkouts -->  
            number of saved workouts:
            @php
                echo count($savedWorkouts);
                echo "<br>saved workout pure data:";
                dd($savedWorkouts);
            @endphp
        @else
            <div class="text-center">
                <p class="lead">You don't have any saved workouts yet.</p>
                <a href="{{ route('generator.show') }}" class="btn btn-primary">Create a Workout</a>
            </div>
        @endif
    </div>
</body>

</html>