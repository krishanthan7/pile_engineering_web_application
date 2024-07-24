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
        <h5 class="modal-title" id="exampleModalLabel">Add Intern Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label> NIC no </label>
                <input type="text" name="nic" class="form-control" placeholder="Enter nic" required>
            </div>
            <div class="form-group">
                <label> Mobile </label>
                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required>
            </div>

            <input type="hidden" name="usertype" value="admin">
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Intern Profile 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add Intern Profile 
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
  $query = "SELECT * FROM registerintern";
  $query_run = mysqli_query($connection, $query);
?>



      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <!-- <th> ID </th> -->
            <th> Username </th>
            <th> NIC number </th>
            <th> Mobile </th>
            <th> Email </th>
            <th> Password</th>
            <th> User Type</th>
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
            <td><?php  echo $row['username']; ?> </td>
            <td><?php  echo $row['nic']; ?> </td>
            <td><?php  echo $row['mobile']; ?> </td>
            <td><?php  echo $row['email']; ?> </td>
            <td><?php  echo $row['password']; ?> </td>
            <td><?php  echo $row['usertype']; ?> </td>
            <td>
                <form action="registereditintern.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                    <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button>
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