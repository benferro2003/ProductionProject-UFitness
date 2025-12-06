<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}">-->
    @vite(['resources/css/app.css', 'resources/js/app.js
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Generated Plan</title>
</head>

<body class="background">

    {{-- NAVBAR --}}
    @include('Navbar')

    {{-- HEADER TITLE --}}
    <section class="section container">
        <h1 class="section-title">Results</h1>
    </section>

    {{-- SUMMARY PANEL --}}
    <section class="section container">
        <div class="panel">

            <div class="row mt-4">

                {{-- LEFT SIDE --}}
                <div class="col-md-6">
                    <h4 class="fw-bold mb-2">Available Days</h4>
                    <ul class="clean-list">
                        @foreach($workoutPlan['available_days'] as $day)
                            <li>{{ $day }}</li>
                        @endforeach
                    </ul>

                    <h4 class="fw-bold mt-4 mb-2">Available Equipment</h4>
                    <ul class="clean-list">
                        @foreach($workoutPlan['equipment'] as $equipment)
                            <li>{{ $equipment }}</li>
                        @endforeach
                    </ul>

                    <h4 class="fw-bold mt-4 mb-2">Desired Difficulty</h4>
                    <ul class="clean-list">
                        <li>{{ $workoutPlan['fitness_level'] }}</li>
                    </ul>
                </div>

                {{-- RIGHT SIDE --}}
                <div class="col-md-6">
                    <h4 class="fw-bold mb-2">Training Goal</h4>
                    <ul class="clean-list">
                        <li>{{ $workoutPlan['training_goal'] }}</li>
                    </ul>

                    <h4 class="fw-bold mt-4 mb-2">Preferred Split</h4>
                    <ul class="clean-list">
                        <li>
                            @if(empty($workoutPlan['workout_split']))
                                No preference
                            @else
                                {{ $workoutPlan['workout_split'] }}
                            @endif
                        </li>
                    </ul>

                    <h4 class="fw-bold mt-4 mb-2">Targeted Muscles</h4>
                    <ul class="clean-list">
                        @foreach($workoutPlan['target_muscles'] as $muscle)
                            <li>{{ $muscle }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{-- WORKOUT PLAN ACCORDION --}}
    <section class="section container">
        <div class="panel">

            <h2 class="section-title">Generated Plan</h2>

            @if(is_array($workoutData) && count($workoutData) > 0)

                <div class="accordion" id="workoutAccordion">

                    @php $dayIndex = 0; @endphp

                    @foreach($workoutData as $day => $exercises)
                        @php $id = 'day' . $dayIndex; @endphp

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $id }}">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $id }}"
                                        aria-expanded="false"
                                        aria-controls="collapse{{ $id }}">
                                    {{ $day }}
                                </button>
                            </h2>

                            <div id="collapse{{ $id }}" class="accordion-collapse collapse"
                                 aria-labelledby="heading{{ $id }}"
                                 data-bs-parent="#workoutAccordion">
                                <div class="accordion-body">

                                    <div class="row">
                                        @foreach($exercises as $exercise)
                                            <div class="col-md-4">
                                                <div class="card exercise-card">

                                                    <div class="card-body">
                                                        <h4 class="fw-bold">{{ $exercise['name'] }}</h4>

                                                        <p><strong>Sets:</strong> {{ $sets }}</p>
                                                        <p><strong>Reps:</strong> {{ $reps }}</p>
                                                        <p><strong>Body Part:</strong> {{ $exercise['bodyPart'] }}</p>
                                                        <p><strong>Target:</strong> {{ $exercise['target'] }}</p>
                                                        <p><strong>Equipment:</strong> {{ $exercise['equipment'] }}</p>

                                                        <img src="{{ $exercise['gifUrl'] }}"
                                                             alt="Exercise GIF"
                                                             class="img-fluid rounded mt-3 mb-3">

                                                        <ul class="clean-list">
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

                        @php $dayIndex++; @endphp
                    @endforeach

                </div>

            @else
                <p class="text-center mt-4">No workout plan available.</p>
            @endif

        </div>
    </section>

    {{-- SAVE BUTTON --}}
    <div class="text-center mt-4 mb-5">
        <form action="{{ route('save.workout') }}" method="POST">
            @csrf
            <input type="hidden" name="workout_plan" value="{{ json_encode($workoutData ?? []) }}">
            <button type="submit" class="ufit-btn px-5 py-3">Save Workout Plan</button>
        </form>
    </div>

</body>
</html>
