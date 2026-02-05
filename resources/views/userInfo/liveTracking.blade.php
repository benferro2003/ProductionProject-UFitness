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
    <title>Live Workout Tracking</title>
</head>

<body class="background">
    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-5">
        <h1 class="section-title">
            WORKOUT - {{ $workoutDate }}
        </h1>

        <div class="mb-5 p-3 border rounded mt-20">
            <div class="accordion" id="workoutAccordion">
                @php 
                    $dayind = 0; 
                @endphp
                
                @foreach($workout as $day => $exercises)
                    @php 
                        $DAY = 'day_' . $dayind; 
                    @endphp
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $DAY }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $DAY }}" aria-expanded="false"
                                aria-controls="collapse{{ $DAY }}">
                                {{ $day }}
                            </button>
                        </h2>
                        
                        <div id="collapse{{ $DAY }}" class="accordion-collapse collapse" 
                            aria-labelledby="heading{{ $DAY }}" data-bs-parent="#workoutAccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    @foreach($exercises as $exercise)
                                        <div class="col-md-4">
                                            <div class="card mb-3" style="height:700px; color: #34495e">
                                                <div class="card-body">
                                                    <h2 class="card-title mt-20" style="font-weight:bold">
                                                        {{ $exercise['name'] }}
                                                    </h2><br>
                                                    <p class="card-text"><strong>Body Part:</strong> {{ $exercise['bodyPart'] }}</p>
                                                    <p class="card-text"><strong>Target Muscle:</strong> {{ $exercise['target'] }}</p>
                                                    <p class="card-text"><strong>Equipment:</strong> {{ $exercise['equipment'] }}</p>
                                                    <p class="card-text"><strong>Instructions:</strong></p>
                                                    <img src="{{ $exercise['gifUrl'] }}" class="img-fluid exercise-img"
                                                        alt="Exercise image"
                                                        onerror="this.src='{{ asset('images/no-exercise.svg') }}'">
                                                    <!--<ul>
                                                        @foreach($exercise['instructions'] as $instruction)
                                                            <li>{{ $instruction }}</li>
                                                        @endforeach
                                                    </ul>-->
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- ADD THIS: Start Live Workout Button for this specific day -->
        <div class="mt-3">
            <form action="POST"method="POST">
                @csrf
                <input type="hidden" name="day_name" value="{{ $day }}">
                <input type="hidden" name="day_index" value="{{ $dayind }}">
                <button type="submit" class="btn btn-success btn-block" style="width: 100%;">
                    Start Live Workout - {{ $day }}
                </button>
            </form>
        </div>
                            </div>
                        </div>
                    </div>
                    
                    @php $dayind++; @endphp
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>