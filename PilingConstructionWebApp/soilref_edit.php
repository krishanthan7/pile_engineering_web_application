<?php
session_start();
include('includes/header.php'); 
include('includes/navbar.php'); 
//include('security.php');
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Material Profile 
            
    </h6>
  </div>

  <div class="card-body">


  <?php


$connection = mysqli_connect('localhost','root','','finalresearch');

  if(isset($_POST['soilref_edit_btn']))
  {
      $id = $_POST['soilref_edit_id'];
      $query = "SELECT * FROM material WHERE id='$id' ";
      $query_run = mysqli_query($connection,$query);

      foreach($query_run as $row)
        {                

  ?>
<form action="soilref_code.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="soilref_edit_id" value="<?php echo $row['id'] ?>">
    
    <div class="form-group">
        <label> Material Name </label>
        <input type="text" name="edit_soilref_name" value="<?php echo $row['material_name'] ?>" class="form-control" >
    </div>
    <div class="form-group">
        <label> Color </label>
        <input type="text" name="edit_color" value="<?php echo $row['color'] ?>" class="form-control" >
    </div>
    <div class="form-group">
        <label> Remarks </label>
        <input type="text" name="edit_remarks" value="<?php echo $row['remarks'] ?>" class="form-control" >
    </div>
    <div class="form-group">
        <label> Image </label>



        <input type="file" name="edit_image" class="form-control-file" >
        <small class="form-text text-muted">Upload a new image if you want to change it.</small>
    </div>
    
    <a href="soilref_register.php" class="btn btn-danger">CANCEL</a>
    <button type="submit" name="soilref_update_btn" class="btn btn-primary">Update</button>
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