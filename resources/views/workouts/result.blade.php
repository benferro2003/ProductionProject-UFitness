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
    <h1 class="Title">Results</h1>
    <div class = "wrapped-containers">
        

        <div class= "left-container">
            <h3>Your Available Days:</h3>
            <ul>
                @foreach($workoutPlan['available_days'] as $day)
                    <li>{{ $day }}</li>
                @endforeach
            </ul>

            <h3>Your Available equipment:</h3>
            <ul>
                @foreach($workoutPlan['equipment'] as $equipment)
                    <li>{{ $equipment }}</li>
                @endforeach
            </ul>

            <h3>Your Desired Difficulty:</h3>
            <ul>
                <li>{{ $workoutPlan['fitness_level'] }}</li>
            </ul>
        </div><br>

       

        <div class="right-container">
            <h3>Your Training Goal:</h3>
            <ul>
                <li>{{ $workoutPlan['training_goal'] }}</li>
            </ul>

            <h3>Your Preffered Duration</h3>
            <ul>
                <li>{{ $workoutPlan['workout_length'] }}</li>
            </ul>
            

            <h3>Your Targeted Muscles:</h3>
            <ul>
                @foreach($workoutPlan['target_muscles'] as $muscle)
                    <li>{{ $muscle }}</li>
                @endforeach
            </ul>
        </div><br>


    </div><br><br>

    <h1 class = "Title" m-10>Generated Workout Plan:</h1>
    <div class="workout-container">
        @if(is_array($workoutData))
            <div class="row">
                @foreach($workoutData as $exercise)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="{{ $exercise['gifUrl']}}" class="card-img-top"
                                alt="Exercise GIF">
                            <div class="card-body">
                                <h5 class="card-title">{{ $exercise['name']}}</h5>
                                <p class="card-text">Target Muscle:{{ $exercise['target']}}</p>
                                <p class="card-text">Body Part:{{ $exercise['bodyPart']}}</p>
                                <p class="card-text">Equipment:{{ $exercise['equipment']}}</p>
                                <p class="card-text">Instructions:</p>
                                <ul>
                                    @foreach($exercise['instructions'] as $instruction)
                                        <li>{{ $instruction }}</li>
                                    @endforeach
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