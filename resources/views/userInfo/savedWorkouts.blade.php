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
        <h1 class="Title">
            My Plans
        </h1>

        @if ($savedWorkouts->isNotEmpty())
            @foreach($savedWorkouts as $workout)
                @php
                    if (is_array($workout->workout_plan)) 
                    {
                        $plan = $workout->workout_plan;
                    } 
                    else 
                    {
                        $plan = json_decode($workout->workout_plan, true);
                    }
                    $workoutID = str_replace('-', '', $workout->created_at->format('d-m-y'));
                @endphp

                <div class="mb-5 p-3 border rounded mt-20">
                    <h1>Workout - {{ $workout->created_at->format('d-m-y') }}</h1>
                    <div class=accordion>
                @php 
                    //counter for day index
                    $dayind = 0; 
                @endphp
                @foreach($plan as $day => $exercises)
                    @php 
                        //Create unique ID for each day in this workout
                        $DAY = 'day' . $workoutID . '_' . $dayind; 
                    @endphp
                    <div class=accordion-item>
                        <!-- Use day index to create unique id for each day -->
                        <h2 class="accordion-header" id="heading{{ $DAY }}">
                            <!-- use bootstrap accordion-button setting it as closed with collapsable elements-->
                            <button class="accordion-button collapsed" 
                                type="button" 
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $DAY }}" aria-expanded="false" aria-controls="collapse{{ $DAY }}">
                                <!-- display day -->
                                {{ $day }}
                            </button>
                        </h2>
                        <!-- Collapsible content with each days related exercises  -->
                        <div id="collapse{{ $DAY }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $DAY }}"
                            data-bs-parent="#workoutAccordion{{ $workoutID }}">
                            <div class="accordion-body">
                                <div class="row">
                                    @foreach($exercises as $exercise)
                                        <div class="col-md-4">
                                            <div class="card mb-3" style="height:1300px; color: #34495e">
                                                <div class="card-body">
                                                    <h2 class="card-title mt-20" style="font-weight:bold">{{ $exercise['name'] }}
                                                    </h2><br>
                                                    <p class="card-text"><strong>Body Part:</strong> {{ $exercise['bodyPart'] }}</p>
                                                    <p class="card-text"><strong>Target Muscle:</strong> {{ $exercise['target'] }}
                                                    </p>
                                                    <p class="card-text"><strong>Equipment:</strong> {{ $exercise['equipment'] }}
                                                    </p>
                                                    <p class="card-text"><strong>Instructions:</strong></p>
                                                    <img src="{{ $exercise['gifUrl'] }}" class="img-fluid exercise-img"
                                                    alt="Exercise image"
                                                    onerror="this.src='{{ asset('images/no-exercise.svg') }}'">
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
                        </div>
                    </div>
                    @php $dayind++; @endphp
                @endforeach
        </div>
                </div>
            @endforeach

        @else
            <div class="text-center">
                <p class="lead">You don't have any saved workouts yet.</p>
                <a href="{{ route('generator.show') }}" class="btn btn-primary">Create a Workout</a>
            </div>
        @endif
    </div>
</body>

</html>