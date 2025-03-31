<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @include('Navbar')
    <title>Calorie Calculator</title>
</head>
<body class="background">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="Title">Calorie Calculator:</h1>
            </div>
        </div>
        <div class="card mt-5" style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form action="{{ route('calculator.calculate', 'calorie') }}" method="POST">
                        @csrf
                        <label for="age">Age (18-50)</label>
                        <input type="text" name="age" id="age" class="form-control" required>

                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <select class="form-control" name="sex" id="sex" required>
                                <option value="" disabled selected>sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <label for="weight">Weight (In kg)</label>
                        <input type="text" name="weight" id="weight" class="form-control" required>

                        <label for="height">Height (In cm)</label>
                        <input type="text" name="height" id="height" class="form-control" required>

                        <div class="form-group">
                            <label for="activity">Activity Level</label>
                            <select class="form-control" name="activity" id="activity" required>
                                <option value="" disabled selected>activity level</option>
                                <option value="bmr">Basal Metabolic Rate (BMR)</option>
                                <option value="sedentary">Sedentary: Little / no exercise</option>
                                <option value="light">Light: exercise 1-3 times per week</option>
                                <option value="moderate">Moderate: exercise 4-5 times per week</option>
                                <option value="active">Active: daily exercise or intense exercise 1-3 times per week</option>
                                <option value="very_active">Very Active: intense exercise 6-7 times per week</option>
                            </select>
                        </div><br>

                        <button type="submit" class="btn btn-primary">Calculate</button>
                    </form>

                    @if(session('result'))
                        <div class="alert alert-success mt-3">
                            Your estimated TDEE is: {{ session('result') }} kcal/day<br>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
