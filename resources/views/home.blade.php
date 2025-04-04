<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    @include('Navbar')
    <h1 class="Title">Welcome to <br> <img src="{{ asset('Dumbbell.png') }}" width="100" height="100" alt="Logo"
            class="navbar-brand"> <br> UniversalFit
    </h1>
</header>

<body class="background">
    <!-- display success and error messages -->
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
    <x-layout>
        <main class>
            <div class="wrapped-containers">
                <div class="left mt-5">
                    <p class="section-title">About us?</p>
                    <p> UFIT is a fitness application that allows users to track their workouts, set goals, and monitor
                        their progress.
                        The application also provides users with a variety of tools such as calculators and workout
                        generators to help them achieve their fitness goals.
                        Whether you are a beginner looking to get started or an experienced athlete looking to take your
                        training to the next level, UFIT has something for everyone.</p>
                </div>

                <div class="right mt-5">
                    <!-- link to track activity / log weight -->
                    <p class="section-title"> Log Progress</p>
                    <div class=wrapped-containers>

                        <a href="{{ route('activityLog.show') }}"
                            class="btn btn-outline-light btn-lg btn-block left">Log Workout</a>
                        <a href="{{ route('weightLog.show') }}" class="btn btn-outline-light btn-lg btn-block right">Log
                            Weight</a>
                    </div>
                </div>

            </div>

            <div class="wrapped-containers">
                <div class="left mt-5">
                    <p class="section-title">Workouts Progress</p>
                    <div class="table-responsive">
                        <table class="table table-dark centre">
                            <thead>
                                <tr>
                                    <th scope="col">Workout Name</th>
                                    <th scope="col">Duration(Mins)</th>
                                    <th scope="col">Date (D/M/Y)</th>
                                    <th scope="col">Total (# workouts)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loggedWorkouts as $workout)
                                    <tr>
                                        <td>{{ $workout->workout_name }}</td>
                                        <td>{{ $workout->duration }}</td>
                                        <td>{{ $workout->created_at->format('d/m/y') }}</td>
                                        <td>{{ $workout->id}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="right mt-5">
                    <p class="section-title">Weight progress</p>
                    <div class="table-responsive">
                        <table class="table table-dark centre">
                            <thead>
                                <tr>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Goal</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loggedWeights as $weight)
                                    <tr>
                                        <td>{{ $weight->weight }}</td>
                                        <td>{{ $weight->goal }}</td>
                                        <td>{{ $weight->created_at->format('d/m/y')}}</td>
                                        <td>{{ $weight->id}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>

    </x-layout>

</body>

</html>