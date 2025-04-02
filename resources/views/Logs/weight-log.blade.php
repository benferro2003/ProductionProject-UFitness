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
    <title>Log Weight</title>
    <h1 class="Title">LOG WEIGHT</h1>
</head>

<body class="background">
    <div class="card mt-5"
        style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
        <form action="{{ route('log.weight') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="form-control-lg">
                        <label class="form-label fw-bold" for="weight">Weight (In kg) :</label>
                        <input type="text" class="form-control" name="weight" id="weight" required>
                    </div><br>
                    <div class="form-control-lg">
                        <label class="form-label fw-bold" for="weight_goal">Goal :</label>
                        <select class="form-select" name="weight_goal" id="weight_goal">
                            <option value="loss">Weight Loss</option>
                            <option value="gain">Weight Gain</option>
                            <option value="maintain">Maintain Weight</option>
                        </select>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-outline-light btn-lg">Log Weight</button>
                    </div>
                </div>
            </div><br>
        </form>
    </div><br><br>
</body>


<footer>
    <div class="card"
    style="background-color: #34495e; color: white; border-radius: 10px;width: 90%;margin: auto;">
        <div class="centre">
            <a href="{{ route('activityLog.show') }}" class="btn btn-outline-light btn-lg btn-block">LOG WORKOUT</a>
        </div>
    </div>
</footer>

</html>