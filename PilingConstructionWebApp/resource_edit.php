<?php
session_start();
include('includes/header.php'); 
include('includes/navbar.php'); 
//include('security.php');
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Resource Profile 
            
    </h6>
  </div>

  <div class="card-body">


  <?php


$connection = mysqli_connect('localhost','root','','finalresearch');

  if(isset($_POST['resource_edit_btn']))
  {
      $id = $_POST['resource_edit_id'];
      $query = "SELECT * FROM resource WHERE id='$id' ";
      $query_run = mysqli_query($connection,$query);

      foreach($query_run as $row)
        {                

  ?>
  <form action="resource_code.php" method="POST">
            <input type="hidden" name="resource_edit_id" value="<?php echo $row['id'] ?>">
            
            <div class="form-group">
                <label> Resource Name </label>
                <input type="text" name="edit_resource_name" value="<?php echo $row['name'] ?>" class="form-control" >
            </div>
            <div class="form-group">
                <label> Quantity </label>
                <input type="text" name="edit_qty" value="<?php echo $row['qty'] ?>" class="form-control" >
            </div>
            
            
            <div class="form-group">
                <label> Cost </label>
                <input type="text" name="edit_cost" value="<?php echo $row['cost'] ?>" class="form-control" >
            </div>
            
            <a href="resource_register.php" class="btn btn-danger"> CANCEL </a>
            <button type="submit" name="resource_update_btn" class="btn btn-primary"> Update </button>
            
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