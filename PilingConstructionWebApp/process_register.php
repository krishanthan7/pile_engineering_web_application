<?php
session_start();
include('includes/header.php'); 
include('includes/intern_navbar.php'); 
//include('security.php');
?>


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Process Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>

          
        </button>
      </div>


      









      <form action="process_code.php" method="POST" >

        <div class="modal-body">

            <div class="form-group">
                <label> Piling Tool </label>
                <input type="text" name="tool" class="form-control" placeholder="Eg: Rock bucket" required>
            </div>
            <div class="form-group">
                <label> Depth from </label>
                <input type="text" name="depth_from" class="form-control" placeholder="Eg: 16.2 m" required>
            </div>
            <div class="form-group">
                <label> Depth to  </label>
                <input type="text" name="depth_to" class="form-control" placeholder="Eg: 16.5 m" >
            </div>
            <div class="form-group">
                <label> Start Time (24hr format)  </label>
                <input type="time" name="start_time" class="form-control" placeholder="Eg: 11.40" >
            </div>
            <div class="form-group">
                <label> End Time (24hr format) </label>
                <input type="time" name="end_time" class="form-control" placeholder="Eg: 15.40" >
            </div>

            
            <!-- <div class="form-group">
                <label> Minutes </label>
                <input type="text" name="minutes" class="form-control" placeholder="Eg: 132.824" required>
            </div> -->
            <div class="form-group">
                <label> Identification of Sample remark </label>
                <input type="text" name="identification" class="form-control" placeholder="Eg: Dark soil" required>
            </div>
            
            
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addprocess_btn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<?php
//session_start(); // Make sure you start the session

$connection = mysqli_connect('localhost', 'root', '', 'finalresearch');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch projects from the database
$queryProjects = "SELECT id, project_name FROM project";
$queryProjects_run = mysqli_query($connection, $queryProjects);

$projects = [];
if (mysqli_num_rows($queryProjects_run) > 0) {
    while ($row = mysqli_fetch_assoc($queryProjects_run)) {
        $projects[] = $row;
    }
}

// Initialize variables
$selectedProject = '';
$selectedPile = '';
$piles = [];

// Check if a project is selected
if (isset($_POST['projectSelect'])) {
    $selectedProject = $_POST['projectSelect'];

    // Fetch piles based on selected project
    $queryPiles = "SELECT id, pile_number FROM pile WHERE fk_project_id = $selectedProject";
    $queryPiles_run = mysqli_query($connection, $queryPiles);

    if (mysqli_num_rows($queryPiles_run) > 0) {
        while ($row = mysqli_fetch_assoc($queryPiles_run)) {
            $piles[] = $row;
        }
    }
}

// Check if a pile is selected and store in session
if (isset($_POST['pileSelect'])) {
    $_SESSION['selectedPile'] = $_POST['pileSelect'];
    $selectedPile = $_POST['pileSelect'];
}
?>

<form method="POST">
    <div class="dropdown">
        <select class="form-control" name="projectSelect" onchange="this.form.submit()">
            <option value="">Select project</option>
            <?php
            foreach ($projects as $project) {
                $isSelected = ($project['id'] == $selectedProject) ? 'selected' : '';
                echo '<option value="' . $project['id'] . '" ' . $isSelected . '>' . $project['project_name'] . '</option>';
            }
            ?>
        </select>
    </div>
</form>

<?php if (!empty($selectedProject)): ?>
    <form method="POST">
        <div class="dropdown mt-3">
            <select class="form-control" name="pileSelect">
                <option value="">Select pile</option>
                <?php
                foreach ($piles as $pile) {
                    $isSelected = ($pile['id'] == $selectedPile) ? 'selected' : '';
                    echo '<option value="' . $pile['id'] . '" ' . $isSelected . '>' . $pile['pile_number'] . '</option>';
                }
                ?>
            </select>
        </div>
        <input type="hidden" name="projectSelect" value="<?php echo $selectedProject; ?>">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
<?php endif; ?>

<?php
// Process the selected pile
if (!empty($selectedPile)) {
    // Fetch process details related to the selected pile
    $queryProcess = "SELECT * FROM process WHERE fk_pile_id = $selectedPile";
    $queryProcess_run = mysqli_query($connection, $queryProcess);

    if (mysqli_num_rows($queryProcess_run) > 0) {
        // Display process details
        while ($row = mysqli_fetch_assoc($queryProcess_run)) {
            //echo '<p>Process Detail: ' . $row['process_detail'] . '</p>';
        }
    } else {
      echo '<br><p style="color: darkred;">No process details found for the selected pile.</p>';

    }
}
?>

<br>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Process Profile
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                Add Process Profile
            </button>
        </h6>
        <!-- <a href="#" onclick="document.getElementById('terminateForm').submit();" class="btn btn-success btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-check"></i>
    </span>
    <span class="text">Terminate the pile</span>
</a> -->

    </div>
</div>



  <div class="card-body">


<?php
    
    if(isset($_SESSION['status_code']) && $_SESSION['status_code'] != ''){
?>
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <?php echo $_SESSION['status']; ?>
        </div>
<?php
        unset($_SESSION['status_code']);
    }
?>


    <div class="table-responsive"> 
    <?php
if(isset($_POST['pileSelect'])) {




  $connection = mysqli_connect('localhost','root','','finalresearch');
  $selectedPile = $_POST['pileSelect'];

  $_SESSION['selectedPile'] = $selectedPile;
  // $query = "SELECT * FROM process WHERE fk_pile_id =  '$selectedPile' ";
  // Assuming $selectedPile contains the selected pile ID
$query = "SELECT * FROM process WHERE fk_pile_id = '$selectedPile' ORDER BY created_at ASC";

  $query_run = mysqli_query($connection, $query);
?>



      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> Tool </th>
            <th> Depth From (in m) </th>
            <th> Depth To (in m) </th>
            <th> Start time  </th>
            <th> End time </th>
            <!-- <th> Consultant</th> -->
            <th> Minutes</th>
            <th> Identification </th>
            <th colspan="2" style="text-align: center;"> Action </th>
            <!-- <th> DELETE </th> -->
          </tr>
        </thead>
        <tbody>
        <?php
            if(mysqli_num_rows($query_run) > 0)        
          {
                while($row = mysqli_fetch_assoc($query_run))
                  {
              ?>
     
          <tr>
            <td><?php  echo $row['tool']; ?> </td>
            <td><?php  echo $row['depth_from']; ?> </td>
            <td><?php  echo $row['depth_to']; ?> </td>
            <td><?php  echo $row['start_time']; ?> </td>
            <td><?php  echo $row['end_time']; ?> </td>
            <!-- <td> // echo $row['consultant']; </td> -->

            <td><?php  echo $row['minutes']; ?> </td>
            <td><?php  echo $row['identification']; ?> </td>
            

            <td>
                <form action="process_edit.php" method="post">
                    <input type="hidden" name="process_edit_id" value="<?php echo $row['id']; ?>">
                    <button  type="submit" name="process_edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="process_code.php" method="post">
                  <input type="hidden" name="process_delete_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="process_delete_btn" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
          </tr>
          <?php
                  } 
              }
              else {
                echo "No Record Found";
              }
            } else {
              echo "Please select a Pile and submit the form.";
            }
        
          ?>
        
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>