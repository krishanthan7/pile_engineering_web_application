<?php
include ('security.php');
include('includes/header.php'); 
include('includes/intern_navbar.php'); 
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
  </div>

  <!-- Content Row -->
  






  <?php
//session_start(); // Start the session
include 'dbconfig.php'; // Include dbconfig.php for database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['projectSelect'])) {
    $_SESSION['selected_project'] = $_POST['projectSelect']; // Store selected project ID in session
}

$query = "SELECT id, project_name FROM project";
$query_run = mysqli_query($connection, $query);

// Fetch project names from the database
$projects = []; // Initialize an empty array
$ids = [];

if (mysqli_num_rows($query_run) > 0) {
    // Loop through the result set
    while ($row = mysqli_fetch_assoc($query_run)) {
        $projects[] = $row['project_name'];
        $ids[] = $row['id'];
    }
}

// Check if a project is already selected in session
$selected_project_id = isset($_SESSION['selected_project']) ? $_SESSION['selected_project'] : '';

?>

<form method="POST">

<div class="dropdown">
  <select class="form-control" name="projectSelect">
    <option value="">Select project</option>
    <?php
    // Populate dropdown options based on fetched projects
    foreach ($projects as $index => $project) {
        $selected = ($ids[$index] == $selected_project_id) ? 'selected' : ''; // Check if this project is selected
        echo '<option value="' . $ids[$index]. '" ' . $selected . '>' . $project . '</option>';
    }
    ?>
  </select>
</div>

<button type="submit" class="btn btn-primary mt-3">Submit</button>

</form>


<?php
if(isset($_POST['projectSelect'])) {

  $selectedProject = $_POST['projectSelect'];

  $_SESSION['selectedProject'] = $selectedProject;
  $query = "SELECT actual_co_North, actual_co_East, pile_number FROM pile WHERE fk_project_id = '$selectedProject'";

  $query_run = mysqli_query($connection, $query);
?>


<div class="container mt-5">
    <h2 class="text-center">Pile location co-ordinate Graph</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<!-- Bootstrap and Chart.js JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Initialize arrays to store x, y data points, and pile numbers
    var xData = [];
    var yData = [];
    var pileNumbers = [];

    <?php
    // Fetch data and store in arrays
    while ($row = mysqli_fetch_assoc($query_run)) {
        echo 'xData.push(' . $row['actual_co_East'] . ');';
        echo 'yData.push(' . $row['actual_co_North'] . ');';
        echo 'pileNumbers.push("' . $row['pile_number'] . '");';
    }
    ?>

    // Data for the scatter graph
    var data = {
        datasets: [{
            label: 'Pile Co-ordinate Dataset',
            data: xData.map((x, i) => ({
                x: x,
                y: yData[i],
                number: pileNumbers[i]
            })),
            backgroundColor: 'rgba(255, 0, 0, 1)',
            borderColor: 'rgba(0, 0, 93, 0.96)',
            borderWidth: 3
        }]
    };

    // Options for the scatter graph
    var options = {
        scales: {
            x: {
                type: 'linear',
                position: 'bottom',
                title: {
                    display: true,
                    text: 'Actual Co East' // Caption for x-axis
                }
            },
            y: {
                type: 'linear',
                position: 'left',
                title: {
                    display: true,
                    text: 'Actual Co North' // Caption for y-axis
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var label = context.raw.number || '';
                        if (label) {
                            label += ' (' + context.raw.x + ', ' + context.raw.y + ')';
                        }
                        return label;
                    }
                }
            }
        }
    };

    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create the scatter graph
    var myChart = new Chart(ctx, {
        type: 'scatter',
        data: data,
        options: options
    });
</script>


<?php } ?>


































<hr class="w-100">






  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Count observed</div><br>
              <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-warning text-uppercase mb-1">
              <img src="img/pile.jpg"  alt="Earnings Icon" style="width: 150px; height: 150px; margin-bottom: 5px;">
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <br>
                <?php 

                require 'dbconfig.php';

                $query ="SELECT id FROM pile ORDER BY id ";
                $query_run = mysqli_query($connection,$query);

                $row = mysqli_num_rows($query_run);
                echo "<h4>"."Pile Registered : ".$row."</h4>"
                ?>

        

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>





       

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Count Observations</div><br>
              <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-warning text-uppercase mb-1">
              <img src="img/process.jpg"  alt="Earnings Icon" style="width: 150px; height: 150px; margin-bottom: 5px;">
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
              <br>
              <?php 

                      require 'dbconfig.php';

                      $query ="SELECT id FROM process ORDER BY id ";
                      $query_run = mysqli_query($connection,$query);

                      $row = mysqli_num_rows($query_run);
                      echo "<h4>"."Pile Process  : ".$row."</h4>"
                      ?>
              </div>
            </div>
            <div class="col-auto">
            
            </div>
          </div>
        </div>
      </div>
    </div>



        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Count Observations</div><br>

              <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-warning text-uppercase mb-1">
              <img src="img/ben.jpg"  alt="Earnings Icon" style="width: 150px; height: 150px; margin-bottom: 5px;">
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
              <br>
              <?php 

                      require 'dbconfig.php';

                      $query ="SELECT id FROM bentonite ORDER BY id ";
                      $query_run = mysqli_query($connection,$query);

                      $row = mysqli_num_rows($query_run);
                      echo "<h4>"."Bentonite test  : ".$row."</h4>"
                      ?>
              </div>
            </div>
            <div class="col-auto">
            
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Content Row -->





  <?php
include('includes/scripts.php');
include('includes/footer.php');
?>