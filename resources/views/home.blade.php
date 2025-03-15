<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Home - UFIT</title>
</head>
<body>
<x-layout>
    
    <header>
        <h1 class="Title">Welcome to <br> <img src="{{ asset('Dumbbell.png') }}" width="500" height="300" alt="Logo" class="navbar-brand"> <br> UniversalFit</h1>
    </header> 



    <main class>
        <div class = "about-container">
            <p class = "section-title">About us?</p>
            <p> UFIT is a fitness application that allows users to track their workouts, set goals, and monitor their progress. 
                The application also provides users with a variety of tools such as calculators and workout generators to help them achieve their fitness goals. 
                Whether you are a beginner looking to get started or an experienced athlete looking to take your training to the next level, UFIT has something for everyone.</p>
        </div>

        <div class = "wrapped-containers">
            <div class = "graph-workouts">
                <p class = "section-title">Workouts Per Week</p>
                <p class = "section-title">workout progress placeholder</p>
                <img src="{{ asset('graph.png') }}"class = "graph"> 
                

            </div>
            <div class = "graph-goals">
                <p class = "section-title">Weight progress</p>
                <p class = "section-title">weight progress placeholder</p>
                <img src="{{ asset('graph.png') }}"class = "graph"> 
            </div>
        </div>
    </main>
</x-layout>
</body>
</html>
