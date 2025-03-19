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
    <title>Workout Generator</title>
</head>

<body class="background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="form-container">
                <h1 class="Title">Generate a Workout</h1>
            </div>
        </div>
        <!-- card with no background color -->
        <div class="card" style="background-color: #34495e; color: white; border-radius: 10px;">
                <form action="{{ route('generate.workout') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-control-lg">
                                <label class = "form-label fw-bold" for="available_days">Available Days:</label><br>
                                <input type="checkbox" name="available_days[]" value="Mon"> Monday<br>
                                <input type="checkbox" name="available_days[]" value="Tue"> Tuesday<br>
                                <input type="checkbox" name="available_days[]" value="Wed"> Wednesday<br>
                                <input type="checkbox" name="available_days[]" value="Thu"> Thursday<br>
                                <input type="checkbox" name="available_days[]" value="Fri"> Friday<br>
                                <input type="checkbox" name="available_days[]" value="Sat"> Saturday<br>
                                <input type="checkbox" name="available_days[]" value="Sun"> Sunday<br>
                            </div><br>

                            <div class="form-control-lg">
                                <label class = "form-label fw-bold" for="equipment">Available Equipment:</label><br>
                                <input type="checkbox" name="equipment[]" value="dumbbell"> Dumbbell<br>
                                <input type="checkbox" name="equipment[]" value="barbell"> Barbell<br>
                                <input type="checkbox" name="equipment[]" value="kettlebell"> Kettlebell<br>
                                <input type="checkbox" name="equipment[]" value="body weight"> BodyWeight<br>
                                <input type="checkbox" name="equipment[]" value="cable"> Cables<br>
                            </div><br>

                            <div class="form-control-lg">
                                <label class = "form-label fw-bold" for="fitness_level">Desired Difficulty:</label required><br>
                                <select  class = "form-select" name="fitness_level" id="fitness_level">
                                    <option value="Beginner">Beginner</option><br>
                                    <option value="Intermediate">Intermediate</option><br>
                                    <option value="Advanced">Advanced</option><br>
                                </select>
                            </div><br>
                        </div>

                        <div class="col-md-6">
                            <div class="form-control-lg">
                                <label class = "form-label fw-bold" for="training_goal">Training Goal:</label required><br>
                                <input type="radio" name="training_goal" value="strength">  Strength training<br>
                                <input type="radio" name="training_goal" value="hypertrophy">   Muscle growth<br>
                                <input type="radio" name="training_goal" value="endurance"> Endurance training<br>
                            </div><br>

                            <div class="form-control-lg">
                                <label class = "form-label fw-bold" for="workout_length">Workout Split: (Optional)</label required><br>
                                <input type="radio" name="workout_split" value="FullBody">   Full Body (best for beginner lifters)<br>
                                <input type="radio" name="workout_split" value="PPL">   Push Pull legs (best for Intermediate lifters)<br>
                                <input type="radio" name="workout_split" value="UpperLower">   Upper Lower (best for Advanced lifters)<br>
                            </div><br>

                            <div class="form-control-lg">
                                <label class = "form-label fw-bold" for="target_muscles">BodyParts to Target:</label required><br>
                                <input type="checkbox" name="target_muscles[]" value = "back"> back<br>
                                <input type="checkbox" name="target_muscles[]" value = "cardio"> cardio<br>
                                <input type="checkbox" name="target_muscles[]" value = "chest"> chest<br>
                                <input type="checkbox" name="target_muscles[]" value = "lower arms"> lower arms<br>
                                <input type="checkbox" name="target_muscles[]" value = "lower legs"> lower legs<br>
                                <input type="checkbox" name="target_muscles[]" value = "neck"> neck<br>
                                <input type="checkbox" name="target_muscles[]" value = "shoulders"> shoulders<br>
                                <input type="checkbox" name="target_muscles[]" value = "upper arms"> upper arms<br>
                                <input type="checkbox" name="target_muscles[]" value = "upper legs"> upper legs<br>
                                <input type="checkbox" name="target_muscles[]" value = "waist"> waist<br>
                            </div><br>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-50" style="background-color: white; color: #34495e; border-radius:10px; border-color: #34495e;"> Generate Workout</button><br><br>
                </form>
            </div>
        </div>
    </div>
</body>

</html>