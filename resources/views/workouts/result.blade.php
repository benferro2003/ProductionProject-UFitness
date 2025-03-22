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
    <div class="wrapped-containers">


        <div class="left-container">
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

            <h3>Your Preffered split</h3>
            <ul>
                <li>{{ $workoutPlan['workout_split'] }}</li>
            </ul>


            <h3>Your Targeted Muscles:</h3>
            <ul>
                @foreach($workoutPlan['target_muscles'] as $muscle)
                    <li>{{ $muscle }}</li>
                @endforeach
            </ul>
        </div><br>


    </div><br><br>

    <h1 style="padding-bottom:100px">**RELOAD PAGE TO SHUFFLE EXERCISES**</h1>

    <h1 class="Title m-150">Generated Workout Plan:</h1>
    <div class="workout-container">
        @if(is_array($workoutData) && count($workoutData) > 0)
            @foreach($workoutData as $day => $exercises)
                <div>
                    <h2 class = "Title" style="align-content:left; margin-top: 50px;"><ul>{{ $day }}</ul></h2>
                    <div class = "row"> 
                        @foreach($exercises as $exercise)
                            <div class="col-md-4">
                                <div class="card mb-3" style="height:1300px; color: #34495e">
                                    <div class="card-body">
                                        <h2 class="card-title mt-20" style="font-weight:bold">{{ $exercise['name'] }}</h2><br>
                                        <p class ="card-text"><strong>Sets:</strong> {{ $sets }}</p>
                                        <p class ="card-text"><strong>Reps:</strong> {{ $reps }}</p>
                                        <p class="card-text"><strong>Body Part:</strong> {{ $exercise['bodyPart'] }}</p>
                                        <p class="card-text"><strong>Target Muscle:</strong> {{ $exercise['target'] }}</p>
                                        <p class="card-text"><strong>Equipment:</strong> {{ $exercise['equipment'] }}</p>
                                        <p class="card-text"><strong>Instructions:</strong></p>
                                        <img src="{{ $exercise['gifUrl'] }}" class="card-img" style="width:fit-content; height: fit-content;" alt="Exercise image">
                                        <ul>
                                            @foreach($exercise['instructions'] as $instruction)
                                                <li>{{ $instruction }}</li>
                                            @endforeach
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <p>No workout plan available.</p>
        @endif
    </div>
</body>
</html>