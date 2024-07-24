<?php
session_start();
include('includes/header.php'); 
include('includes/intern_navbar.php'); 
//include('security.php');
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Process Profile 
            
    </h6>
  </div>

  <div class="card-body">


  <?php


$connection = mysqli_connect('localhost','root','','finalresearch');

  if(isset($_POST['process_edit_btn']))
  {
      $id = $_POST['process_edit_id'];
      $query = "SELECT * FROM process WHERE id='$id' ";
      $query_run = mysqli_query($connection,$query);

      foreach($query_run as $row)
        {                

  ?>
  <form action="process_code.php" method="POST">
            <input type="hidden" name="process_edit_id" value="<?php echo $row['id'] ?>">
            

            <div class="form-group">
                <label> Piling Tool </label>
                <input type="text" name="tool" class="form-control" value="<?php echo $row['tool'] ?>">
            </div>
            <div class="form-group">
                <label> Depth from </label>
                <input type="text" name="depth_from" class="form-control" value="<?php echo $row['depth_from'] ?>">
            </div>
            <div class="form-group">
                <label> Depth to  </label>
                <input type="text" name="depth_to" class="form-control" value="<?php echo $row['depth_to'] ?>" >
            </div>
            <div class="form-group">
                <label> Start Time  </label>
                <input type="time" name="start_time" class="form-control" value="<?php echo $row['start_time'] ?>" >
            </div>
            <div class="form-group">
                <label> End Time  </label>
                <input type="time" name="end_time" class="form-control" value="<?php echo $row['end_time'] ?>">
            </div>
            
            <div class="form-group">
                <label> Identification of Sample remark </label>
                <input type="text" name="identification" class="form-control" value="<?php echo $row['identification'] ?>">
            </div>
            
            <!-- <div class="form-group">
                <label>Project Status</label>
                <select name="update_projectstatus" class="form-control">
                    <option value="Yes">Completed</option>
                    <option value="No">Not Completed</option>

                </select>
            </div> -->
            <a href="process_register.php" class="btn btn-danger"> CANCEL </a>
            <button type="submit" name="process_update_btn" class="btn btn-primary"> Update </button>
            
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