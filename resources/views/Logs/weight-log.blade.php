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
    <h1 class="Title">
        WORKOUT LOG
    </h1>
</header>

<body class="background">
</body>

<footer>
    <div class="footer">
            <div class="centre mt-5">
                <a href="{{ route('activityLog.show') }}" class="btn btn-outline-light btn-lg btn-block left">LOG WORKOUT</a>
            </div> 
        </div>
    </div>
</footer>

</html>