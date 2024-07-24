<?php
session_start();
include('includes/header.php'); 
include('includes/navbar.php'); 
//include('security.php');
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Project Profile 
            
    </h6>
  </div>

  <div class="card-body">


  <?php


$connection = mysqli_connect('localhost','root','','finalresearch');

  if(isset($_POST['project_edit_btn']))
  {
      $id = $_POST['project_edit_id'];
      $query = "SELECT * FROM project WHERE id='$id' ";
      $query_run = mysqli_query($connection,$query);

      foreach($query_run as $row)
        {                

  ?>
  <form action="project_code.php" method="POST">
            <input type="hidden" name="project_edit_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> Project Code </label>
                <input type="text" name="edit_project_code" value="<?php echo $row['project_code'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Project Name </label>
                <input type="text" name="edit_project_name" value="<?php echo $row['project_name'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Project Location </label>
                <input type="text" name="edit_location" value="<?php echo $row['location'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Project Cost </label>
                <input type="text" name="edit_cost" value="<?php echo $row['cost'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> End Client </label>
                <input type="text" name="edit_client" value="<?php echo $row['client'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Project consultant  </label>
                <input type="text" name="edit_consultant" value="<?php echo $row['consultant'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Start Date </label>
                <input type="date" name="edit_start_date" value="<?php echo $row['start_date'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> End Date </label>
                <input type="date" name="edit_end_date" value="<?php echo $row['end_date'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Estimated Duration (in Months) </label>
                <input type="text" name="edit_duration" value="<?php echo $row['duration'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> No of Piles </label>
                <input type="text" name="edit_pilecount" value="<?php echo $row['pilecount'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Assigned Project Manager </label>
                <input type="text" name="edit_assigned_pm" value="<?php echo $row['assigned_pm'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Assigned Engineer/Assistant Engineer</label>
                <input type="text" name="edit_assigned_engr" value="<?php echo $row['assigned_engr'] ?>" class="form-control" >
            </div>
            <div class="form-group">
            <label>Project Status</label>
                <select name="update_projectstatus" class="form-control">
                    <option value="Yes" <?php echo ($row['project_status'] == 'Yes') ? 'selected' : ''; ?>>Completed</option>
                    <option value="No" <?php echo ($row['project_status'] == 'No') ? 'selected' : ''; ?>>Not Completed</option>
                </select>
            </div>
            <a href="project_register.php" class="btn btn-danger"> CANCEL </a>
            <button type="submit" name="project_update_btn" class="btn btn-primary"> Update </button>
            
            </form>   
            <?php
                }
            }
        ?>
  </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->
</div> <!-- Closing tag for card-body -->

</div> <!-- Closing tag for card -->

</div> <!-- Closing tag for container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>