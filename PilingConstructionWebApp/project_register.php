<?php
session_start();
include('includes/header.php'); 
include('includes/navbar.php'); 
//include('security.php');
?>


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Project Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="project_code.php" method="POST" >

        <div class="modal-body">

            <div class="form-group">
                <label> Project Code </label>
                <input type="text" name="project_code" class="form-control" placeholder="Eg: PTK001" required>
            </div>
            <div class="form-group">
                <label> Project Name </label>
                <input type="text" name="project_name" class="form-control" placeholder="Eg: Highway piling project" required>
            </div>
            <div class="form-group">
                <label> Project Location </label>
                <input type="text" name="location" class="form-control" placeholder="Eg: Colombo" required>
            </div>
            <div class="form-group">
                <label> Project Cost </label>
                <input type="text" name="cost" class="form-control" placeholder="Eg: $50 000.00" required>
            </div>
            <div class="form-group">
                <label> End Client </label>
                <input type="text" name="client" class="form-control" placeholder="Eg: Abc (pvt) ltd" required>
            </div>
            <div class="form-group">
                <label> Project consultant  </label>
                <input type="text" name="consultant" class="form-control" placeholder="Eg: Xyz (pvt) ltd" required>
            </div>
            <div class="form-group">
                <label> Start Date </label>
                <input type="date" name="start_date" class="form-control" placeholder="Select here ... " required>
            </div>
            <div class="form-group">
                <label> End Date </label>
                <input type="date" name="end_date" class="form-control" placeholder="Select here ... " required>
            </div>
            <div class="form-group">
                <label> Estimated Duration (in Months) </label>
                <input type="text" name="duration" class="form-control" placeholder="Eg: 6 month" required>
            </div>
            <div class="form-group">
                <label> No of Piles </label>
                <input type="text" name="pilecount" class="form-control" placeholder="Eg: 230" required>
            </div>
            <div class="form-group">
                <label> Assigned Project Manager </label>
                <input type="text" name="assigned_pm" class="form-control" placeholder="Eg: Mr Akil" required>
            </div>
            <div class="form-group">
                <label> Assigned Engineer/Assistant Engineer</label>
                <input type="text" name="assigned_engr" class="form-control" placeholder="Eg: Mr Rakesh" required>
            </div>

            <input type="hidden" name="project_status" value="No">
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addproject_btn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Project Profile 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add Project Profile 
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
  $connection = mysqli_connect('localhost','root','','finalresearch');
  $query = "SELECT * FROM project";
  $query_run = mysqli_query($connection, $query);
?>



      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <!-- <th> ID </th> -->
            <th> Project Code </th>
            <th> Project Name </th>
            <th> Location </th>
            <th> Client </th>
            <!-- <th> Consultant</th> -->
            <th> Pile Count</th>
            <th> Project Completion </th>
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
            <!-- <td><?php  //echo $row['id']; ?> </td> -->
            <td><?php  echo $row['project_code']; ?> </td>
            <td><?php  echo $row['project_name']; ?> </td>
            <td><?php  echo $row['location']; ?> </td>
            <td><?php  echo $row['client']; ?> </td>
            <!-- <td> // echo $row['consultant']; </td> -->

            <td><?php  echo $row['pilecount']; ?> </td>
            <td style="color: <?php echo ($row['project_status'] == 'Yes') ? 'green' : 'red'; ?>">
                  <?php echo $row['project_status']; ?>
            </td>

            <td>
                <form action="project_edit.php" method="post">
                    <input type="hidden" name="project_edit_id" value="<?php echo $row['id']; ?>">
                    <button  type="submit" name="project_edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="project_code.php" method="post">
                  <input type="hidden" name="project_delete_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="project_delete_btn" class="btn btn-danger"> DELETE</button>
                </form>
            </td>
          </tr>
          <?php
                  } 
              }
              else {
                echo "No Record Found";
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