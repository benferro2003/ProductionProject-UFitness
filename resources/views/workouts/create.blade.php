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
                <h1 class="Title">Generate a Workout</h1>
            </div>
        </div>
        <div class="form-container">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('generate.workout') }}" method="POST">
                    @csrf
                   
                   
                    <div class="form-group">
                    <label for="available_days">Available Days:</label><br>
                    <!-- radio form allowing multiple days to be selected -->
                    <input type="checkbox" name="available_days[]" value="Mon"> Monday<br>
                    <input type="checkbox" name="available_days[]" value="Tue"> Tuesday<br>
                    <input type="checkbox" name="available_days[]" value="Wed"> Wednesday<br>
                    <input type="checkbox" name="available_days[]" value="Thu"> Thursday<br>
                    <input type="checkbox" name="available_days[]" value="Fri"> Friday<br>
                    <input type="checkbox" name="available_days[]" value="Sat"> Saturday<br>
                    <input type="checkbox" name="available_days[]" value="Sun"> Sunday<br>
                    </div><br>

                    <div class="form-group">
                    <label for="equipment">Available Equipment:</label><br>
                    <input type="checkbox" name="equipment[]" value="dumbbell"> Dumbbell<br>
                    <input type="checkbox" name="equipment[]" value="barbell"> Barbell<br>
                    <input type="checkbox" name="equipment[]" value="kettlebell"> Kettlebell<br>
                    <input type="checkbox" name="equipment[]" value="body weight"> BodyWeight<br>
                    <input type="checkbox" name="equipment[]" value="cable"> Cables<br>
                    </div><br>

                    <div class="form-group">
                    <label for="fitness_level">Fitness Level:</label required><br>
                    <select name="fitness_level" id="fitness_level">
                        <option value="Beginner">Beginner</option><br>
                        <option value="Intermediate">Intermediate</option><br>
                        <option value="Advanced">Advanced</option><br>
                    </select>
                    </div><br>

                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
