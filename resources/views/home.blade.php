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

<body>
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
                    <div class = wrapped-containers>
                        
                    <a href="{{ route('generator.show') }}" class="btn btn-primary btn-lg btn-block left mt-5">Log Weight</a>
                    <a href="{{ route('generator.show') }}" class="btn btn-primary btn-lg btn-block right mt-5">Track Activity</a>
                    </div>
                </div>

            </div>

            <div class="wrapped-containers">
                <div class="left mt-5">
                    <p class="section-title">Workouts Progress</p>
                    <img src="{{ asset('graph.png') }}" class="img-fluid centre-graph">


                </div>
                <div class="right mt-5">
                    <p class="section-title">Weight progress</p>
                    <img src="{{ asset('graph.png') }}" class="img-fluid centre-graph">
                </div>
            </div>
        </main>
    </x-layout>
</body>

</html>