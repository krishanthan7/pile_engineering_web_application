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
            <h6 class="m-0 font-weight-bold text-primary">Calculate End Bearing Capacity</h6>
        </div>
        
        <div class="card-body">
             <form action="" method="post">
                <div class="form-group">
                    <label for="diameter">Pile Diameter (m):</label>
                    <input type="number" class="form-control" id="diameter" name="diameter" step="0.01" placeholder="e.g., 0.5" required>
                </div>
                <div class="form-group">
                    <label for="depth">Pile Depth (m):</label>
                    <input type="number" class="form-control" id="depth" name="depth" step="0.01" placeholder="e.g., 10.0" required>
                </div>
                <div class="form-group">
                    <label for="bearing_capacity">Ultimate End Bearing Resistance (kN/m²):</label>
                    <input type="number" class="form-control" id="bearing_capacity" name="bearing_capacity" step="0.01" placeholder="e.g., 2500" required>
                </div>
                <button type="submit" class="btn btn-primary">Calculate</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $diameter = $_POST['diameter'];
                $depth = $_POST['depth'];
                $bearing_capacity = $_POST['bearing_capacity'];

                // Calculate the cross-sectional area of the pile tip
                $radius = $diameter / 2;
                $area = pi() * pow($radius, 2);

                // Calculate the ultimate bearing capacity
                $ultimate_bearing_capacity = $area * $bearing_capacity;

                echo "<div class='result mt-4'>";
                echo "<h3>Calculation Result</h3>";
                echo "<p><strong>Pile Diameter:</strong> " . $diameter . " m</p>";
                echo "<p><strong>Pile Depth:</strong> " . $depth . " m</p>";
                echo "<p><strong>Ultimate End Bearing Resistance:</strong> " . $bearing_capacity . " kN/m²</p>";
                echo "<p style='color: green;'><strong>End Bearing Capacity:</strong> " . $ultimate_bearing_capacity . " kN</p>";

                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>
