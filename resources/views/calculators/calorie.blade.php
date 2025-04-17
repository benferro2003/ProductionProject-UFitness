<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
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
        <div class="card mt-5"
            style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form action="{{ route('calculator.calculate', 'calorie') }}" method="POST">
                        @csrf
                        <label for="age">Age (18-50)</label>
                        <input type="text" name="age" id="age" class="form-control" value="{{ old('age') }}" required>
                        @error('age')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <select class="form-control" name="sex" id="sex" value="{{ old('sex') }}" required>
                                <option value="" disabled selected>sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('sex')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="weight">Weight (In kg)</label>
                        <input type="text" name="weight" id="weight" class="form-control" value="{{ old('weight') }}"
                            required>
                        @error('weight')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <label for="height">Height (In cm)</label>
                        <input type="text" name="height" id="height" class="form-control" value="{{ old('height') }}"
                            required>
                        @error('height')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="activity">Activity Level</label>
                            <select class="form-control" name="activity" id="activity" value="{{ old('activity') }}"
                                required>
                                <option value="" disabled selected>activity level</option>
                                <option value="bmr">Basal Metabolic Rate (BMR)</option>
                                <option value="sedentary">Sedentary: Little / no exercise</option>
                                <option value="light">Light: exercise 1-3 times per week</option>
                                <option value="moderate">Moderate: exercise 4-5 times per week</option>
                                <option value="active">Active: daily exercise or intense exercise 1-3 times per week
                                </option>
                                <option value="very_active">Very Active: intense exercise 6-7 times per week</option>
                            </select>
                            @error('activity')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div><br>

                        <button type="submit" class="btn btn-primary">Calculate</button>
                    </form>
                </div>
            </div>
        </div>
        @if(session('result'))
            <div class="centre mt-5">
                <p class="section-title">Your Results</p>
                <p>
                    Your estimated TDEE is: {{ session('result') }} kcal/day<br>
                    This is the amount of daily calories you need to maintain your current weight.
                </p>
            </div>

            <div class="wrapped-containers">

                <div class="left">
                    <!-- table for displaying the amount of calories needed to gain weight per week -->
                    <table class="table table-bordered mt-3" style="text-align: center;">
                        <thead>
                            <tr>
                                <th>Weight Gain (kg/week)</th>
                                <th>Calories Needed (kcal/day)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0.25 - Safest</td>
                                <td>{{ session('result') + 250 }} </td>
                            </tr>
                            <tr>
                                <td>0.5 - Moderate</td>
                                <td>{{ session('result') + 500 }} </td>
                            </tr>
                            <tr>
                                <td>1 - Extreme</td>
                                <td>{{ session('result') + 1000 }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="right">
                    <!-- table for displaying the amount of calories needed to lose weight per week -->
                    <table class="table table-bordered mt-3" style="text-align: center;">
                        <thead>
                            <tr>
                                <th>Weight Loss (kg/week)</th>
                                <th>Calories Needed (kcal/day)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0.25 - Safest</td>
                                <td>{{ session('result') - 250 }} </td>
                            </tr>
                            <tr>
                                <td>0.5 - Moderate</td>
                                <td>{{ session('result') - 500 }} </td>
                            </tr>
                            <tr>
                                <td>1 - Extreme</td>
                                <td>{{ session('result') - 1000 }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
    </div>
</body>

</html>