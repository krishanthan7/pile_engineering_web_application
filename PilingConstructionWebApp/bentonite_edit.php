<?php
session_start();
include('includes/header.php'); 
include('includes/intern_navbar.php'); 
//include('security.php');
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Bentonite Profile 
            
    </h6>
  </div>

  <div class="card-body">


  <?php


$connection = mysqli_connect('localhost','root','','finalresearch');

  if(isset($_POST['bentonite_edit_btn']))
  {
      $id = $_POST['bentonite_edit_id'];
      $query = "SELECT * FROM bentonite WHERE id='$id' ";
      $query_run = mysqli_query($connection,$query);

      foreach($query_run as $row)
        {                

  ?>
  <form action="bentonite_code.php" method="POST">
            <input type="hidden" name="bentonite_edit_id" value="<?php echo $row['id'] ?>">
            
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
                <input type="text" name="density" class="form-control" value="<?php echo $row['density'] ?>">
            </div>
            <div class="form-group">
                <label> Viscosity </label>
                <input type="text" name="viscosity" class="form-control" value="<?php echo $row['viscosity'] ?>">
            </div>
            <div class="form-group">
                <label> PH value </label>
                <input type="text" name="ph" class="form-control" value="<?php echo $row['ph'] ?>" >
            </div>
            <div class="form-group">
                <label> Sand content  </label>
                <input type="text" name="sand_content" class="form-control" value="<?php echo $row['sand_content'] ?>" >
            </div>
            <div class="form-group">
                <label> Time  </label>
                <input type="text" name="time" class="form-control" value="<?php echo $row['time'] ?>">
            </div>
                 

          
            <!-- <div class="form-group">
                <label>Project Status</label>
                <select name="update_projectstatus" class="form-control">
                    <option value="Yes">Completed</option>
                    <option value="No">Not Completed</option>

                </select>
            </div> -->
            <a href="bentonite_register.php" class="btn btn-danger"> CANCEL </a>
            <button type="submit" name="bentonite_update_btn" class="btn btn-primary"> Update </button>
            
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