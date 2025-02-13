<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <!-->bootstrap stylesheet used</-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
     <!-->bootstrap javascript used</-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<header>
    @include('Navbar')
</header>
<body class = "background">
    {{$slot}}
</body>
</html>