<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @include('Navbar')
    <title>Workout Generator</title>
</head>
<body class="background">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Workout Generator</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('generate.workout') }}" method="POST">
                    @csrf
                   
                   
                    <div class="form-group">
                    <label for="available_days">Available Days:</label>
                    <select name="available_days" id="available_days" class="form-control">
                    </select>
                    </div>

                    <div class="form-group">
                    <label for="equipment">Available Equipment:</label>
                    <select name="equipment" id="equipment" class="form-control">
                    </select>
                    </div>

                    <div class="form-group">
                    <label for="fitness_level">Fitness Level:</label>
                    <select name="fitness_level" id="fitness_level" class="form-control">
                    </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
