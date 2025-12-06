<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}">-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Workout Generator</title>
</head>

<body class="background">

    {{-- NAVBAR --}}
    @include('Navbar')

    <section class="section container">
        <div class="panel">

            <h1 class="generate-title">GENERATE WORKOUT</h1>
            <BR>

            <form action="{{ route('generate.workout') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- LEFT COLUMN --}}
                    <div class="col-md-6">

                        {{-- Available Days --}}
                        <div class="form-group">
                            <label class="fw-bold">Available Days:</label>
                            <div class="ufit-checkbox-group">
                                <label><input type="checkbox" name="available_days[]" value="all days"> Select All</label>
                                <label><input type="checkbox" name="available_days[]" value="Mon"> Monday</label>
                                <label><input type="checkbox" name="available_days[]" value="Tue"> Tuesday</label>
                                <label><input type="checkbox" name="available_days[]" value="Wed"> Wednesday</label>
                                <label><input type="checkbox" name="available_days[]" value="Thu"> Thursday</label>
                                <label><input type="checkbox" name="available_days[]" value="Fri"> Friday</label>
                                <label><input type="checkbox" name="available_days[]" value="Sat"> Saturday</label>
                                <label><input type="checkbox" name="available_days[]" value="Sun"> Sunday</label>
                            </div>
                            @error('available_days')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Equipment --}}
                        <div class="form-group mt-4">
                            <label class="fw-bold">Available Equipment:</label>
                            <div class="ufit-checkbox-group">
                                <label><input type="checkbox" name="equipment[]" value="all equipment"> Select All</label>
                                <label><input type="checkbox" name="equipment[]" value="dumbbell"> Dumbbell</label>
                                <label><input type="checkbox" name="equipment[]" value="barbell"> Barbell</label>
                                <label><input type="checkbox" name="equipment[]" value="kettlebell"> Kettlebell</label>
                                <label><input type="checkbox" name="equipment[]" value="body weight"> Bodyweight</label>
                                <label><input type="checkbox" name="equipment[]" value="cable"> Cable</label>
                            </div>
                            @error('equipment')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Difficulty --}}
                        <div class="form-group mt-4">
                            <label class="fw-bold">Desired Difficulty:</label>
                            <select class="form-select" name="fitness_level">
                                <option value="" disabled selected>Select level</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            @error('fitness_level')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="col-md-6">

                        {{-- Training Goal --}}
                        <div class="form-group">
                            <label class="fw-bold">Training Goal:</label>
                            <div class="ufit-radio-group">
                                <label><input type="radio" name="training_goal" value="strength"> Strength</label>
                                <label><input type="radio" name="training_goal" value="hypertrophy"> Muscle Growth</label>
                                <label><input type="radio" name="training_goal" value="endurance"> Endurance</label>
                            </div>
                            @error('training_goal')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Workout Split --}}
                        <div class="form-group mt-4">
                            <label class="fw-bold">Workout Split (Optional):</label>
                            <div class="ufit-radio-group">
                                <label><input type="radio" name="workout_split" value="FullBody"> Full Body</label>
                                <label><input type="radio" name="workout_split" value="PPL"> Push Pull Legs</label>
                                <label><input type="radio" name="workout_split" value="UpperLower"> Upper / Lower</label>
                            </div>
                            @error('workout_split')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Target Muscles --}}
                        <div class="form-group mt-4">
                            <label class="fw-bold">Body Parts to Target:</label>
                            <div class="ufit-checkbox-group">
                                <label><input type="checkbox" name="target_muscles[]" value="full body"> Full Body</label>
                                <label><input type="checkbox" name="target_muscles[]" value="back"> Back</label>
                                <label><input type="checkbox" name="target_muscles[]" value="cardio"> Cardio</label>
                                <label><input type="checkbox" name="target_muscles[]" value="chest"> Chest</label>
                                <label><input type="checkbox" name="target_muscles[]" value="lower arms"> Lower Arms</label>
                                <label><input type="checkbox" name="target_muscles[]" value="shoulders"> Shoulders</label>
                                <label><input type="checkbox" name="target_muscles[]" value="upper arms"> Upper Arms</label>
                                <label><input type="checkbox" name="target_muscles[]" value="upper legs"> Upper Legs</label>
                                <label><input type="checkbox" name="target_muscles[]" value="waist"> Abs</label>
                            </div>
                            @error('target_muscles')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <button type="submit" class="ufit-btn w-100 mt-4">Generate Workout</button>

            </form>
        </div>
    </section>

</body>
</html>
