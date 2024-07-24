<?php
session_start();
include('includes/header.php'); 
include('includes/intern_navbar.php'); 
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

  if(isset($_POST['pile_edit_btn']))
  {
      $id = $_POST['pile_edit_id'];
      $query = "SELECT * FROM pile WHERE id='$id' ";
      $query_run = mysqli_query($connection,$query);

      foreach($query_run as $row)
        {                

  ?>
  <form action="pile_code.php" method="POST">
            <input type="hidden" name="pile_edit_id" value="<?php echo $row['id'] ?>">
            
            <div class="form-group">
                <label> Pile Number </label>
                <input type="text" name="pile_number" class="form-control" value="<?php echo $row['pile_number'] ?>">
            </div>
            <div class="form-group">
                <label> Plie Location </label>
                <input type="text" name="pile_location" class="form-control" value="<?php echo $row['pile_location'] ?>">
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates North(Actual)  </label>
                <input type="text" name="actual_co_North" class="form-control" value="<?php echo $row['actual_co_North'] ?>">
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates East(Actual)  </label>
                <input type="text" name="actual_co_East" class="form-control" value="<?php echo $row['actual_co_East'] ?>">
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates (Design) </label>
                <input type="text" name="design_co_North" class="form-control" value="<?php echo $row['design_co_North'] ?>">
            </div>
            <div class="form-group">
                <label> Pile Co-ordinates (Design) </label>
                <input type="text" name="design_co_East" class="form-control" value="<?php echo $row['design_co_East'] ?>">
            </div>
            <div class="form-group">
                <label> Date </label>
                <input type="date" name="date" class="form-control" value="<?php echo $row['date'] ?>">
            </div>
            <div class="form-group">
                <label> Machine Type </label>
                <input type="text" name="machine_type" class="form-control" value="<?php echo $row['machine_type'] ?>">
            </div>
            <div class="form-group">
                <label> Ground Level </label>
                <input type="text" name="ground_level" class="form-control" value="<?php echo $row['ground_level'] ?>">
            </div>
            <div class="form-group">
                <label> Casing Top Level </label>
                <input type="text" name="ctl" class="form-control" value="<?php echo $row['ctl'] ?>">
            </div>
            <div class="form-group">
                <label> Cut off lLevel </label>
                <input type="text" name="col" class="form-control" value="<?php echo $row['col'] ?>">
            </div>

          
            <div class="form-group">
                <label>Pile Status</label>
                <select name="pile_update_status" class="form-control">
                    <option value="Yes">Completed</option>
                    <option value="No">Not Completed</option>

                </select>
            </div>
            <a href="pile_register.php" class="btn btn-danger"> CANCEL </a>
            <button type="submit" name="pile_update_btn" class="btn btn-primary"> Update </button>
            
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