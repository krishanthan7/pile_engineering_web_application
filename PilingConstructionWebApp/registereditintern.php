<?php
session_start();
include('includes/header.php'); 
include('includes/navbar.php'); 
//include('security.php');
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Intern Profile 
            
    </h6>
  </div>

  <div class="card-body">


  <?php


$connection = mysqli_connect('localhost','root','','finalresearch');

  if(isset($_POST['edit_btn']))
  {
      $id = $_POST['edit_id'];
      $query = "SELECT * FROM registerintern WHERE id='$id' ";
      $query_run = mysqli_query($connection,$query);

      foreach($query_run as $row)
        {                

  ?>
  <form action="code.php" method="POST">
            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> Username </label>
                <input type="text" name="edit_username" value="<?php echo $row['username'] ?>" class="form-control" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label> NIC no </label>
                <input type="text" name="edit_nic" value="<?php echo $row['nic'] ?>" class="form-control" placeholder="Enter nic">
            </div>
            <div class="form-group">
                <label> Mobile </label>
                <input type="text" name="edit_mobile" value="<?php echo $row['mobile'] ?>" class="form-control" placeholder="Enter Mobile">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="edit_email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="edit_password" value="<?php echo $row['password'] ?>"class="form-control" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label>User Type</label>
                <select name="update_usertype" class="form-control">
                    <option value="admin" <?php echo ($row['usertype'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Intern" <?php echo ($row['usertype'] == 'Intern') ? 'selected' : ''; ?>>Intern</option>
                </select>
            </div>
            <a href="register.php" class="btn btn-danger"> CANCEL </a>
            <button type="submit" name="updatebtn" class="btn btn-primary"> Update </button>
            
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

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>