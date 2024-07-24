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
        <h5 class="modal-title" id="exampleModalLabel">Add Pile Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="pile_code.php" method="POST" >

        <div class="modal-body">

            <div class="form-group">
                <label> Pile Number </label>
                <input type="text" name="pile_number" class="form-control" placeholder="Eg: BFPP-02" required>
            </div>
            <div class="form-group">
                <label> Plie Location </label>
                <input type="text" name="pile_location" class="form-control" placeholder="Eg: BFPP" required>
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates North(Actual)  </label>
                <input type="text" name="actual_co_North" class="form-control" placeholder="Eg: 132.819" >
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates East(Actual)  </label>
                <input type="text" name="actual_co_East" class="form-control" placeholder="Eg: 174.698" >
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates North(Design) </label>
                <input type="text" name="design_co_North" class="form-control" placeholder="Eg: 132.824" required>
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates East(Design) </label>
                <input type="text" name="design_co_East" class="form-control" placeholder="Eg: 174.696" required>
            </div>
            <div class="form-group">
                <label> Date </label>
                <input type="date" name="date" class="form-control" placeholder=" " required>
            </div>
            <div class="form-group">
                <label> Machine Type </label>
                <input type="text" name="machine_type" class="form-control" placeholder="Eg: BG-25" required>
            </div>
            <div class="form-group">
                <label> Ground Level </label>
                <input type="text" name="ground_level" class="form-control" placeholder="Eg: -0.644 " required>
            </div>
            <div class="form-group">
                <label> Casing Top Level </label>
                <input type="text" name="ctl" class="form-control" placeholder="Eg: +0.103/+0.105 " required>
            </div>
            <div class="form-group">
                <label> Cut off lLevel </label>
                <input type="text" name="col" class="form-control" placeholder="Eg: -1.165" required>
            </div>
            <input type="hidden" name="pile_status" value="No">
            <!-- <input type="hidden" name="project_status" value="No"> -->
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addpile_btn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->


<?php


$connection = mysqli_connect('localhost', 'root', '', 'finalresearch');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['projectSelect'])) {
    $_SESSION['selected_project'] = $_POST['projectSelect']; // Store selected project in session
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




<br>


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Pile Profile
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add Pile Profile 
            </button>
    </h6>
  </div>
 <!-- Bar Chart -->
 



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
if(isset($_POST['projectSelect'])) {




  $connection = mysqli_connect('localhost','root','','finalresearch');
  $selectedProject = $_POST['projectSelect'];

  $_SESSION['selectedProject'] = $selectedProject;
  $query = "SELECT * FROM pile WHERE fk_project_id =  '$selectedProject' ";
  $query_run = mysqli_query($connection, $query);
?>



      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

        <thead>
          <tr>
            <th> ID </th>
            <th> Pile Number </th>
            <th> Pile Location </th>
            <th> Date </th>
            <th> Ground Level </th>
            <!-- <th> Consultant</th> -->
            <th> Casing Top Level</th>
            <th> Cut Off Level </th>
            <th> Pile Termination </th>
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
            <td><?php  echo $row['id']; ?> </td>
            <td><?php  echo $row['pile_number']; ?> </td>
            <td><?php  echo $row['pile_location']; ?> </td>
            <td><?php  echo $row['date']; ?> </td>
            <td><?php  echo $row['ground_level']; ?> </td>
            <!-- <td> // echo $row['consultant']; </td> -->

            <td><?php  echo $row['ctl']; ?> </td>
            <td><?php  echo $row['col']; ?> </td>
            <td style="color: <?php echo ($row['pile_status'] == 'Yes') ? 'green' : 'red'; ?>">
                  <?php echo $row['pile_status']; ?>
            </td>
            

            <td>
                <form action="pile_edit.php" method="post">
                    <input type="hidden" name="pile_edit_id" value="<?php echo $row['id']; ?>">
                    <button  type="submit" name="pile_edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="pile_code.php" method="post">
                  <input type="hidden" name="pile_delete_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="pile_delete_btn" class="btn btn-danger"> DELETE</button>
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
              echo "Please select a project and submit the form.";
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