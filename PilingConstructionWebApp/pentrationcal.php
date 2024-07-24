<?php
session_start();
include('includes/header.php'); 
include('includes/intern_navbar.php'); 
?>

<!-- Include Bootstrap and jQuery (if not already included) -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Calculate Penetration Rate</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="depth">Depth in (mm)</label>
                <input type="number" class="form-control" id="depth" aria-describedby="depthHelp"  required>
                <small id="depthHelp" class="form-text text-muted">Enter depth in millimeters</small>
            </div>
            <div class="form-group">
                <label for="stime">Start time</label>
                <input type="time" class="form-control" id="stime">
            </div>
            <div class="form-group">
                <label for="etime">End time</label>
                <input type="time" class="form-control" id="etime">
            </div>
            <button type="button" class="btn btn-primary" onclick="calculatePenetrationRate()">Calculate</button>
            <br>
            <br>
            <h2 id="penetrationRate"></h2>
        </div>
    </div>
</div>

<script>
    function calculatePenetrationRate() {
        var depth = parseFloat(document.getElementById('depth').value);
        var startTime = document.getElementById('stime').value;
        var endTime = document.getElementById('etime').value;

        if (isNaN(depth) || !startTime || !endTime) {
            document.getElementById('penetrationRate').innerText = "Invalid input. Please check your inputs.";
            return;
        }

        var start = new Date("01/01/2022 " + startTime);
        var end = new Date("01/01/2022 " + endTime);

        var timeDifference = Math.abs(end - start); // in milliseconds
        var hours = timeDifference / 1000 / 60 / 60; // convert to hours

        var penetrationRate = depth / hours;

        document.getElementById('penetrationRate').innerText = "Penetration Rate: " + penetrationRate.toFixed(2) + " mm/h";
    }
</script>

<?php
include('includes/footer.php');
?>
