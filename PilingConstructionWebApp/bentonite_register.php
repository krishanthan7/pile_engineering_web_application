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
        <h5 class="modal-title" id="exampleModalLabel">Add Bentonite Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="bentonite_code.php" method="POST" >

        <div class="modal-body">

            <div class="form-group">
                <label>Stage </label>
                <select name="stage" class="form-control">
                    <option value="As supplied">As supplied</option>
                    <option value="Before placing Reinforcement Cage">Before placing Reinforcement Cage</option>
                    <option value="Before start concreting">Before start concreting </option>
                </select>
            </div>
            <div class="form-group">
                <label> Density </label>
                <input type="text" name="density" class="form-control" placeholder="Eg:  1.15 g/ml" required>
            </div>
            <div class="form-group">
                <label> Viscosity </label>
                <input type="text" name="viscosity" class="form-control" placeholder="Eg: 16.2 sec/litre" required>
            </div>
            <div class="form-group">
                <label> PH value </label>
                <input type="text" name="ph" class="form-control" placeholder="Eg: 7.5" >
            </div>
            <div class="form-group">
                <label> Sand content  </label>
                <input type="text" name="sand_content" class="form-control" placeholder="Eg: 3.5%" >
            </div>
            <div class="form-group">
                <label> Time  </label>
                <input type="text" name="time" class="form-control" placeholder="Eg: 13:40" >
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addbentonite_btn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->



<?php
//session_start(); // Start the session to store the selected pile

$connection = mysqli_connect('localhost', 'root', '', 'finalresearch');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT id, pile_number FROM pile";
$query_run = mysqli_query($connection, $query);

// Fetch project names from the database
$piles = []; // Initialize an empty array
$ids = [];
$selectedPile = ''; // Initialize selectedPile variable

if (mysqli_num_rows($query_run) > 0) {
    // Loop through the result set
    while ($row = mysqli_fetch_assoc($query_run)) {
        $piles[] = $row['pile_number'];
        $ids[] = $row['id'];
    }
}

// Check if a pile is selected and stored in session
if (isset($_SESSION['selectedPile'])) {
    $selectedPile = $_SESSION['selectedPile'];
}
?>

<form method="POST">
    <div class="dropdown">
        <select class="form-control" name="pileSelect">
            <option value="">Select pile</option>
            <?php
            // Populate dropdown options based on fetched projects
            foreach ($piles as $index => $pile) {
                $isSelected = ($ids[$index] == $selectedPile) ? 'selected' : ''; // Check if this option is selected
                echo '<option value="' . $ids[$index] . '" ' . $isSelected . '>' . $pile . '</option>';
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>

























<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Bentonite Profile 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add Bentonite 
            </button>
    </h6>
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
  $query = "SELECT * FROM bentonite WHERE fk_pile_id =  '$selectedPile' ";
  $query_run = mysqli_query($connection, $query);
?>



      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> Stage </th>
            <th> Density </th>
            <th> Viscosity</th>
            <th> PH value </th>
            <th> Sand content  </th>
            <th> time </th>
            <!-- <th> Consultant</th> -->
 
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
            <td><?php  echo $row['stage']; ?> </td>
            <td><?php  echo $row['density']; ?> </td>
            <td><?php  echo $row['viscosity']; ?> </td>
            <td><?php  echo $row['ph']; ?> </td>
            <td><?php  echo $row['sand_content']; ?> </td>
            <!-- <td> // echo $row['consultant']; </td> -->

            <td><?php  echo $row['time']; ?> </td>
            
            

            <td>
                <form action="bentonite_edit.php" method="post">
                    <input type="hidden" name="bentonite_edit_id" value="<?php echo $row['id']; ?>">
                    <button  type="submit" name="bentonite_edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="bentonite_code.php" method="post">
                  <input type="hidden" name="bentonite_delete_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="bentonite_delete_btn" class="btn btn-danger"> DELETE</button>
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