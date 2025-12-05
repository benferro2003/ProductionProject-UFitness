<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="background">

    {{-- NAVBAR --}}
    @include('Navbar')

    {{-- HERO / WELCOME --}}
    <section class="section container">
        <div class="hero">
            <h1 class="hero-title">Welcome to<br>UniversalFit</h1>
            <img src="/images/ufit-logo.svg" class="hero-icon" alt="UFIT Logo">
            <p class="subtitle mt-3">
                Track your workouts, monitor progress, and achieve your fitness goals.
            </p>
        </div>
    </section>

    {{-- SUCCESS / ERROR MESSAGES --}}
    <div class="container mt-4">
        @if(session('error'))
            <div class="alert alert-warning text-center">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-info text-center">{{ session('success') }}</div>
        @endif
    </div>


    {{-- ABOUT + LOG PROGRESS --}}
    <section class="section container">
        <div class="flex">
            
            {{-- ABOUT CARD --}}
            <div class="col-50">
                <div class="panel">
                    <h2 class="section-title">About UFIT</h2>
                    <p class="subtitle mt-3">
                        UFIT is a fitness application that allows users to track their workouts, set goals, and monitor progress.
                        The application also provides users with tools such as calculators and workout generators to help them 
                        achieve their fitness goals. Whether you are a beginner or an experienced athlete, UFIT has something 
                        for everyone.
                    </p>
                </div>
            </div>

            {{-- LOG PROGRESS CARD --}}
            <div class="col-50">
                <div class="panel">
                    <h2 class="section-title">Log Progress</h2>

                    <div class="d-flex gap-3 flex-wrap justify-content-center mt-4">
                        <a href="{{ route('activityLog.show') }}" class="ufit-btn">Log Workout</a>
                        <a href="{{ route('weightLog.show') }}" class="ufit-btn">Log Weight</a>
                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- TABLES: WORKOUT + WEIGHT --}}
    <section class="section container">
        <div class="flex">

            {{-- WORKOUT TABLE --}}
            <div class="col-50">
                <div class="panel">
                    <h2 class="section-title">Workouts Progress</h2>

                    <div class="table-responsive">
                        <table class="ufit-table">
                            <thead>
                                <tr>
                                    <th>Workout Name</th>
                                    <th>Duration (mins)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loggedWorkouts as $workout)
                                    <tr>
                                        <td>{{ $workout->workout_name }}</td>
                                        <td>{{ $workout->duration }}</td>
                                        <td>{{ $workout->created_at->format('d/m/y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            {{-- WEIGHT TABLE --}}
            <div class="col-50">
                <div class="panel">
                    <h2 class="section-title">Weight Progress</h2>

                    <div class="table-responsive">
                        <table class="ufit-table">
                            <thead>
                                <tr>
                                    <th>Weight (KG)</th>
                                    <th>Goal</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loggedWeights as $weight)
                                    <tr>
                                        <td>{{ $weight->weight }}</td>
                                        <td>{{ $weight->goal }}</td>
                                        <td>{{ $weight->created_at->format('d/m/y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </section>


    {{-- GOOGLE CHARTS: ONLY DISPLAY IF DATA EXISTS --}}
    @if($workoutCount->isNotEmpty() || $loggedWeights->isNotEmpty())

    <section class="section container">
        <div class="flex">

            {{-- WORKOUT GRAPH --}}
            @if($workoutCount->isNotEmpty())
                <div class="col-50">
                    <div class="panel">
                        <h2 class="section-title">Activity</h2>
                        <div id="workoutChart" class="workoutGraph"></div>

                        <script src="https://www.gstatic.com/charts/loader.js"></script>
                        <script>
                            google.charts.load('current', { packages: ['corechart'] });
                            google.charts.setOnLoadCallback(drawWorkoutChart);

                            function drawWorkoutChart() {
                                const data = google.visualization.arrayToDataTable([
                                    ['Week', 'Workouts'],
                                    @foreach ($workoutCount as $week => $count)
                                        ['{{ $week }}', {{ $count }}],
                                    @endforeach
                                ]);

                                const options = {
                                    hAxis: { title: 'Week' },
                                    vAxis: { title: 'Frequency' },
                                    legend: 'none',
                                    backgroundColor: 'white',
                                    colors: ['#3FA9F5']
                                };

                                new google.visualization.ColumnChart(
                                    document.getElementById('workoutChart')
                                ).draw(data, options);
                            }
                        </script>
                    </div>
                </div>
            @endif


            {{-- WEIGHT GRAPH --}}
            @if($loggedWeights->isNotEmpty())
                <div class="col-50">
                    <div class="panel">
                        <h2 class="section-title">Weight Trend</h2>
                        <div id="weightChart" class="weightGraph"></div>

                        <script>
                            google.charts.load('current', { packages: ['corechart'] });
                            google.charts.setOnLoadCallback(drawWeightChart);

                            function drawWeightChart() {
                                const data = google.visualization.arrayToDataTable([
                                    ['Date', 'Weight'],
                                    @foreach ($loggedWeights as $weight)
                                        ['{{ $weight->created_at->format('d/m') }}', {{ $weight->weight }}],
                                    @endforeach
                                ]);

                                const options = {
                                    hAxis: { title: 'Date' },
                                    vAxis: { title: 'Weight (KG)' },
                                    legend: 'none',
                                    backgroundColor: 'white',
                                    colors: ['#3FA9F5']
                                };

                                new google.visualization.LineChart(
                                    document.getElementById('weightChart')
                                ).draw(data, options);
                            }
                        </script>
                    </div>
                </div>
            @endif

        </div>
    </section>

    @endif


</body>
</html>

