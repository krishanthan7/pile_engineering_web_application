<?php
include ('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 

//session_start(); // Start the session - Check if this is needed here

// Include database configuration
include 'dbconfig.php'; 


?>



<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <form method="POST" action="generate_pdf.php">
        <button type="submit" name="generateSummary" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Project Summary
        </button>
    </form>
  </div>

  <!-- Your other content goes here -->

</div>





<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"></h1>

<!-- Get Report Button -->


</div>

<div class="container-fluid">


  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->







    <?php
include('dbconfig.php');

// Fetch data for area graph (project names and costs)
$queryArea = "SELECT project_name, cost FROM project";
$resultArea = mysqli_query($connection, $queryArea);

// Initialize arrays for area graph
$projectNamesArea = [];
$costsArea = [];

// Populate arrays for area graph
while ($row = mysqli_fetch_assoc($resultArea)) {
    $projectNamesArea[] = $row['project_name'];
    $costsArea[] = $row['cost'];
}

// Fetch data for bar graph (project names and pile counts)
$queryBar = "SELECT project_name, pilecount FROM project";
$resultBar = mysqli_query($connection, $queryBar);

// Initialize arrays for bar graph
$projectNamesBar = [];
$pileCountsBar = [];

// Populate arrays for bar graph
while ($row = mysqli_fetch_assoc($resultBar)) {
    $projectNamesBar[] = $row['project_name'];
    $pileCountsBar[] = $row['pilecount'];
}
?>



<div class="container">
        <div class="row">
            <div class="col-md-6">
                <canvas id="areaChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <script>
    // Area Chart
    var ctxArea = document.getElementById('areaChart').getContext('2d');
    var areaChart = new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($projectNamesArea); ?>,
            datasets: [{
                label: 'Project Costs',
                data: <?php echo json_encode($costsArea); ?>,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        autoSkip: false, // Prevent automatic skipping of labels
                        maxRotation: 0, // Set rotation angle to 0 degrees
                        minRotation: 0 // Set rotation angle to 0 degrees
                    }
                }
            }
        }
    });

    // Bar Chart
    var ctxBar = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($projectNamesBar); ?>,
            datasets: [{
                label: 'Pile Counts',
                data: <?php echo json_encode($pileCountsBar); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        autoSkip: false, // Prevent automatic skipping of labels
                        maxRotation: 0, // Set rotation angle to 0 degrees
                        minRotation: 0 // Set rotation angle to 0 degrees
                    }
                }
            }
        }
    });
</script>


<br/><br/><br/><br/><br/>
<hr class="w-100">









































 <!-- Earnings (Monthly) Card Example -->
 <div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-primary text-uppercase mb-1">
            <img src="img/total.png" alt="Trainee Icon" style="width: 100px; height: 100px; margin-bottom: 5px;">
            Total count
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
            <?php 
            require 'dbconfig.php';
            $query = "SELECT id FROM registerintern ORDER BY id";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_num_rows($query_run);
            echo "<h4>"."Total No : ".$row."</h4>";
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

 <div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-primary text-uppercase mb-1">
            <img src="img/pm.png" alt="Project Manager Icon" style="width: 100px; height: 100px; margin-bottom: 5px;">
            Project Manager
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
            <?php 
            require 'dbconfig.php';
            $query = "SELECT id FROM registerintern WHERE usertype='admin' ORDER BY id";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_num_rows($query_run);
            echo "<h4>"."Total Count : ".$row."</h4>";
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
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-primary text-uppercase mb-1">
            <img src="img/intern.jpg" alt="Intern/Assistant Engineer Icon" style="width: 100px; height: 100px; margin-bottom: 5px;">
            Intern/ Assistant Engineer
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
            <?php 
            require 'dbconfig.php';
            $query = "SELECT id FROM registerintern WHERE usertype='intern' ORDER BY id";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_num_rows($query_run);
            echo "<h4>"."Total Count : ".$row."</h4>";
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


<!-- 
    <hr class="w-100"> -->

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-success shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-success text-uppercase mb-1">
            <img src="img/project.png" alt="Total Projects Icon" style="width: 100px; height: 100px; margin-bottom: 5px;">
            Total Projects Taken so far
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
            <?php 
            require 'dbconfig.php';
            $query = "SELECT id FROM project ORDER BY id";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_num_rows($query_run);
            echo "<h4>"."Count : ".$row."</h4>";
            ?>
          </div>
        </div>
        <div class="col-auto">
          <!-- Leave empty as there's no content here -->
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
          <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-success text-uppercase mb-1">
            <img src="img/complete.png" alt="Completed Projects Icon" style="width: 100px; height: 100px; margin-bottom: 5px;">
            Completed Projects
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
            <?php 
            require 'dbconfig.php';
            $query = "SELECT id FROM project WHERE project_status ='Yes' ORDER BY id";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_num_rows($query_run);
            echo "<h4>"."Total : ".$row."</h4>";
            ?>
          </div>
        </div>
        <div class="col-auto">
          <!-- Leave empty as there's no content here -->
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
          <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-success text-uppercase mb-1">
            <img src="img/pending.png" alt="Pending Projects Icon" style="width: 100px; height: 100px; margin-bottom: 5px;">
            Pending Projects
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
            <?php 
            require 'dbconfig.php';
            $query = "SELECT id FROM project WHERE project_status ='No' ORDER BY id";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_num_rows($query_run);
            echo "<h4>"."Total : ".$row."</h4>";
            ?>
          </div>
        </div>
        <div class="col-auto">
          <!-- Leave empty as there's no content here -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 
    <hr class="w-100"> -->

    
<div class="col-xl-4 col-md-6 mb-4">
  <div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="d-flex flex-column align-items-center text-xs font-weight-bold text-warning text-uppercase mb-1">
            <img src="img/amount.png" alt="Earnings Icon" style="width: 100px; height: 100px; margin-bottom: 5px;">
            Earnings
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
            <?php
            require 'dbconfig.php';

            $query = "SELECT SUM(cost) AS total_amount FROM project";
            $query_run = mysqli_query($connection, $query);

            // Check if the query ran successfully
            if ($query_run) {
                // Fetch the result row as an associative array
                $result = mysqli_fetch_assoc($query_run);
                
                // Access the 'total_amount' value from the result array
                $totalAmount = $result['total_amount'];

                // Output the total amount
                echo "<h4>Total Amount: $$totalAmount.00</h4>";
            } else {
                echo "Error fetching total amount.";
            }
            ?>
          </div>
        </div>
        <div class="col-auto">
          <!-- Leave empty as there's no content here -->
        </div>
      </div>
    </div>
  </div>
</div>

</div>
<br>

<hr class="w-100"> <hr class="w-100">


  <div class="row">
  <!-- Content Column -->
  



    <?php
$connection = mysqli_connect('localhost', 'root', '', 'finalresearch');
$query = "SELECT p.id, p.project_code, p.project_name, p.pilecount, COUNT(pl.fk_project_id) AS piles_count
  FROM project p
  LEFT JOIN pile pl ON p.id = pl.fk_project_id AND pl.pile_status = 'yes'
  GROUP BY p.id, p.project_code, p.project_name, p.pilecount";

$query_run = mysqli_query($connection, $query);

$projects = [];

if ($query_run) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $project_name = $row['project_name'];
        $total_piles = $row['pilecount'];
        $completed_piles = $row['piles_count'];

        $projects[] = [
            'name' => $project_name,
            'totalPiles' => $total_piles,
            'completedPiles' => $completed_piles
        ];
    }
} else {
    echo "Query failed: " . mysqli_error($connection);
}


?>





















  <div class="container">
    <div class="row">
        <!-- Column for Projects Pending Status -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects Pending Status</h6>
                </div>
                <div class="card-body">
                    <?php foreach ($projects as $project): ?>
                    <h4 class="small font-weight-bold"><?php echo $project['name']; ?>
                        <span class="float-right">
                            <?php
                            $completionPercentage = ($project['completedPiles'] / $project['totalPiles']) * 100;
                            $completionPercentage = number_format($completionPercentage, 2); // Format to two decimal places
                            echo $completionPercentage . '%';
                            ?>
                        </span>
                    </h4>
                    <div class="progress mb-4" style="width: 100%;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $completionPercentage; ?>%"
                            aria-valuenow="<?php echo $completionPercentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- End Column for Projects Pending Status -->

        <!-- Column for Recent Clients -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Clients</h6>
                </div>
                <div class="card-body">
                    <div id="clientCarousel" class="carousel slide" data-ride="carousel" data-interval="2500">
                        <div class="carousel-inner">
                            <!-- <div class="carousel-item active">
                                <img class="d-block img-fluid" src="img/user-group-296.svg" alt="Client 1">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-fluid" src="img/user-exchange-318.svg" alt="Client 2">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-fluid" src="img/network-team-308.svg" alt="Client 3">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-fluid" src="img/networking-320.svg" alt="Client 4">
                            </div>
                        </div> -->
                    </div>

                    <?php
                    require 'dbconfig.php';

                    $query = "SELECT DISTINCT client FROM project";
                    $query_run = mysqli_query($connection, $query);

                    // Check if the query ran successfully
                    if (mysqli_num_rows($query_run) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($query_run)) {

                            echo '<div style="background-color: #f2f2f2; padding: 10px; margin-bottom: 10px;">';
                            echo '<strong>' . $row["client"] . '</strong> <br>';
                            echo '</div>';
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- End Column for Recent Clients -->
    </div>
</div>













































































  <?php
include('includes/scripts.php');
include('includes/footer.php');
?>