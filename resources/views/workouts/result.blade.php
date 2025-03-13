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
    <title>Generated Workout Plan</title>
</head>

<body class="background">
    <div>
        <h1 class="Title">Results</h1>

        <div class="about-container">
            <h3>Your Available Days:</h3>
            <ul>
                @foreach($workoutPlan['available_days'] as $day)
                    <li>{{ $day }}</li>
                @endforeach
            </ul>
        </div>

        <div class="about-container">
            <h3>Your Available equipment:</h3>
            <ul>
                @foreach($workoutPlan['equipment'] as $equipment)
                    <li>{{ $equipment }}</li>
                @endforeach
            </ul>
        </div>

        <div class="about-container">
            <h3>Your Fitness Level:</h3>
            <p>{{ $workoutPlan['fitness_level'] }}</p>
        </div>
    </div><br><br>

    <h1 class = "Title" m-10>Generated Workout Plan:</h1>
    <div class="workout-container">
        @if(is_array($workoutData))
            <div class="row">
                @foreach($workoutData as $exercise)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="{{ $exercise['gifUrl'] ?? 'https://via.placeholder.com/150' }}" class="card-img-top"
                                alt="Exercise GIF">
                            <div class="card-body">
                                <h5 class="card-title">{{ $exercise['name']}}</h5>
                                <p class="card-text">Target Muscle:{{ $exercise['target']}}</p>
                                <p class="card-text">Body Part:{{ $exercise['bodyPart']}}</p>
                                <p class="card-text">Equipment:{{ $exercise['equipment']}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No exercises found for the selected criteria.</p>
        @endif
    </div>



</body>

</html>