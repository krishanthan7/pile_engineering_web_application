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
        <h5 class="modal-title" id="exampleModalLabel">Add Concrete Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="cube_test_code.php" method="POST" >

        <div class="modal-body">

            <div class="form-group">
                <label> Casted date </label>
                <input type="date" name="cast_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label> Tested date </label>
                <input type="date" name="test_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label> Age (days) </label>
                <input type="text" name="ph" class="form-control" placeholder="Eg: 30" >
            </div>
            <div class="form-group">
                <label> Length 1 (mm) </label>
                <input type="text" name="len1" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Width 1  (mm)</label>
                <input type="text" name="wid1" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Height 1 (mm) </label>
                <input type="text" name="height1" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Weight 1 (g) </label>
                <input type="text" name="weight1" class="form-control" placeholder="Eg: 8585" >
            </div>
            <div class="form-group">
                <label> Strength 1 (KN) </label>
                <input type="text" name="strength1" class="form-control" placeholder="Eg: 1067.5" >
            </div>
            <div class="form-group">
                <label> Length 2 (mm)</label>
                <input type="text" name="len2" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Width 2 (mm) </label>
                <input type="text" name="wid2" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Height 2 (mm) </label>
                <input type="text" name="height2" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Weight 2 (g) </label>
                <input type="text" name="weight2" class="form-control" placeholder="Eg: 8601" >
            </div>
            <div class="form-group">
                <label> Strength 2 (KN)</label>
                <input type="text" name="strength2" class="form-control" placeholder="Eg: 1011.5" >
            </div>
            <div class="form-group">
                <label> Length 3 (mm) </label>
                <input type="text" name="len3" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Width 3 (mm) </label>
                <input type="text" name="wid3" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Height 3  (mm)</label>
                <input type="text" name="height3" class="form-control" placeholder="Eg: 150" >
            </div>
            <div class="form-group">
                <label> Weight 3 (g)</label>
                <input type="text" name="weight3" class="form-control" placeholder="Eg: 8475" >
            </div>
            <div class="form-group">
                <label> Strength 3 (KN) </label>
                <input type="text" name="strength3" class="form-control" placeholder="Eg: 1056.4" >
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addconcretecube_btn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Cube test Profile 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add test results 
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
  $query = "SELECT * FROM bentonite";
  $query_run = mysqli_query($connection, $query);
?>



      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
          <tr>
              <th rowspan="3">Casted date</th>
              <th rowspan="3">Tested date</th>
              <th rowspan="3">Age</th>
              <th colspan="3">Dimensions</th>
              <th rowspan="3">Weight</th>
              <th rowspan="3">Strength</th>
              <th colspan="2" rowspan="3" style="text-align: center;"> Action </th>
            </tr>
            <tr>
              <td>L</td>
              <td>W</td>
              <td>H</td>
            </tr>
            
 
            
           
          </tr>
        </thead>
        <tbody>
        <?php
        //     if(mysqli_num_rows($query_run) > 0)        
        //   {
        //         while($row = mysqli_fetch_assoc($query_run))
        //           {
              ?>
     
          
          <!-- <tr>
                    <td rowspan="3">1</td>
                    <td rowspan="3">2</td>
                    <td rowspan="3"></td>
                    <td ></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
        

            
          </tr> -->

          <tr>
            <!-- Merged Cells for Casted date, Tested date, Age -->
            <td rowspan="3"></td>
            <td rowspan="3"></td>
            <td rowspan="3"></td>
            <!-- End of Merged Cells -->
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

            <td>
                <form action="bentonite_edit.php" method="post">
                    <input type="hidden" name="bentonite_edit_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="bentonite_edit_btn" class="btn btn-success">EDIT</button>
                </form>
            </td>
            <td>
                <form action="bentonite_code.php" method="post">
                    <input type="hidden" name="bentonite_delete_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="bentonite_delete_btn" class="btn btn-danger">DELETE</button>
                </form>
            </td>
        </tr>
      
        <!-- <td>
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
                    </td> -->


                 

    
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