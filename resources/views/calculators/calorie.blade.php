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

    <div class="container mt-5">

        <h1 class="section-title text-center">Calorie Calculator</h1>

        {{-- CALCULATOR FORM PANEL --}}
        <div class="panel mt-4">

            <form action="{{ route('calculator.calculate', 'calorie') }}" method="POST">
                @csrf

                <div class="row g-4">

                    <div class="col-md-6 offset-md-3">

                        {{-- Age --}}
                        <label for="age" class="fw-bold">Age (18–50)</label>
                        <input type="text" name="age" id="age" class="form-control"
                               value="{{ old('age') }}" required>
                        @error('age')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror

                        {{-- Sex --}}
                        <div class="form-group mt-3">
                            <label for="sex" class="fw-bold">Sex</label>
                            <select class="form-control" name="sex" id="sex" required>
                                <option value="" disabled selected>Sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('sex')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Weight --}}
                        <label for="weight" class="fw-bold mt-3">Weight (kg)</label>
                        <input type="text" name="weight" id="weight" class="form-control"
                               value="{{ old('weight') }}" required>
                        @error('weight')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror

                        {{-- Height --}}
                        <label for="height" class="fw-bold mt-3">Height (cm)</label>
                        <input type="text" name="height" id="height" class="form-control"
                               value="{{ old('height') }}" required>
                        @error('height')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror

                        {{-- Activity Level --}}
                        <div class="form-group mt-3">
                            <label for="activity" class="fw-bold">Activity Level</label>
                            <select class="form-control" name="activity" id="activity" required>
                                <option value="" disabled selected>Activity level</option>
                                <option value="bmr">Basal Metabolic Rate (BMR)</option>
                                <option value="sedentary">Sedentary: Little / no exercise</option>
                                <option value="light">Light: exercise 1-3 times per week</option>
                                <option value="moderate">Moderate: exercise 4-5 times per week</option>
                                <option value="active">Active: daily exercise or intense exercise 1-3 times per week</option>
                                <option value="very_active">Very Active: intense exercise 6-7 times per week</option>
                            </select>
                            @error('activity')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <button type="submit" class="ufit-btn w-100 mt-4">Calculate</button>

                    </div>

                </div>

            </form>

        </div>

        {{-- RESULTS SECTION --}}
        @if(session('result'))

            <div class="panel mt-5 text-center">

                <p class="section-title">Your Results</p>

                <p class="subtitle">
                    Your estimated TDEE is:
                    <strong>{{ session('result') }} kcal/day</strong><br>
                    This is the number of calories needed to maintain your weight.
                </p>

                {{-- WRAPPED RESULTS TABLES --}}
                <div class="wrapped-containers mt-4">

                    <div class="left">
                        <!-- table for displaying the amount of calories needed to gain weight per week -->
                        <table class="table clean-table mt-3 text-center">
                            <thead>
                                <tr>
                                    <th>Weight Gain (kg/week)</th>
                                    <th>Calories Needed (kcal/day)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0.25 – Safest</td>
                                    <td>{{ session('result') + 250 }}</td>
                                </tr>
                                <tr>
                                    <td>0.5 – Moderate</td>
                                    <td>{{ session('result') + 500 }}</td>
                                </tr>
                                <tr>
                                    <td>1 – Extreme</td>
                                    <td>{{ session('result') + 1000 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="right">
                        <!-- table for displaying the amount of calories needed to lose weight per week -->
                        <table class="table clean-table mt-3 text-center">
                            <thead>
                                <tr>
                                    <th>Weight Loss (kg/week)</th>
                                    <th>Calories Needed (kcal/day)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0.25 – Safest</td>
                                    <td>{{ session('result') - 250 }}</td>
                                </tr>
                                <tr>
                                    <td>0.5 – Moderate</td>
                                    <td>{{ session('result') - 500 }}</td>
                                </tr>
                                <tr>
                                    <td>1 – Extreme</td>
                                    <td>{{ session('result') - 1000 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        @endif

    </div>

</body>

</html>
