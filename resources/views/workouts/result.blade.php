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


        <div class="left">
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



        <div class="right">
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

    <!-- DISPLAY USING BOOTSTRAP ACCORDIAN https://getbootstrap.com/docs/5.0/components/accordion/ -->
    <h1 class="Title">Workout Plan:</h1>
    <div class="container mt-5">
        @if(is_array($workoutData) && count($workoutData) > 0)
                <!-- Use accordion to display workout data -->
                <div class="mb-5 p-3 border rounded">
                    <div class=accordion>
                        @php 
                                                    //counter for day index
                            $dayind = 0; 
                        @endphp
                        @foreach($workoutData as $day => $exercises)
                                    @php 
                                                                        //set day variable to day index
                                        $DAY = 'day' . $dayind; 
                                    @endphp
                                    <div class=accordion-item>
                                        <!-- Use day index to create unique id for each day -->
                                        <h2 class="accordion-header" id="heading{{ $DAY }}">
                                            <!-- use bootstrap accordion-button setting it as closed with collapsable elements-->
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $DAY }}" aria-expanded="false"
                                                aria-controls="collapse{{ $DAY }}">
                                                <!-- display day -->
                                                {{ $day }}
                                            </button>
                                        </h2>
                                        <!-- Collapsible content with each days related exercises  -->
                                        <div id="collapse{{ $DAY }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $DAY }}"
                                            data-bs-parent="#workoutAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    @foreach($exercises as $exercise)
                                                        <div class="col-md-4">
                                                            <div class="card mb-3" style="height:2000px; color: #34495e">
                                                                <div class="card-body">
                                                                    <h2 class="card-title mt-20" style="font-weight:bold">
                                                                        {{ $exercise['name'] }}
                                                                    </h2><br>
                                                                    <p class="card-text"><strong>Sets:</strong> {{ $sets }}</p>
                                                                    <p class="card-text"><strong>Reps:</strong> {{ $reps }}</p>
                                                                    <p class="card-text"><strong>Body Part:</strong> {{ $exercise['bodyPart'] }}
                                                                    </p>
                                                                    <p class="card-text"><strong>Target Muscle:</strong>
                                                                        {{ $exercise['target'] }}
                                                                    </p>
                                                                    <p class="card-text"><strong>Equipment:</strong>
                                                                        {{ $exercise['equipment'] }}
                                                                    </p>
                                                                    <p class="card-text"><strong>Instructions:</strong></p>
                                                                    <img src="{{ $exercise['gifUrl'] }}" class="img-fluid exercise-img"
                                                                    alt="Exercise image">
                                                                    <ul>
                                                                        @foreach($exercise['instructions'] as $instruction)
                                                                            <li>{{ $instruction }}</li>
                                                                        @endforeach
                                                                    </ul>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $dayind++; @endphp
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        @endforeach
        @else
            <p>No workout plan available.</p>
        @endif
            </div>
        </div>
    </div>
    <div class="text-center mt-5 mb-5 pt-4">
        <form action="{{ route('save.workout') }}" method="POST">
            @csrf
            <input type="hidden" name="workout_plan" value="{{ $workoutData ? json_encode($workoutData) : '{}' }}">
            <button type="submit" class="btn btn-primary btn-lg px-5 py-3">Save Workout Plan</button>
        </form>
    </div>
</body>

</html>