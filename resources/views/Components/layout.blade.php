<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <!-- Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>

<body class="background">
    <header>
        @include('Navbar')
    </header>

    <main>
        {{$slot}}
    </main>
</body>
</html>
