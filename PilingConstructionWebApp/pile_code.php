<?php 
session_start();
$connection = mysqli_connect('localhost','root','','finalresearch');

if(isset($_POST['addpile_btn'])) {
    $pile_number = $_POST['pile_number'];
    $pile_location = $_POST['pile_location'];
    $actual_co_North = $_POST['actual_co_North'];
    $actual_co_East = $_POST['actual_co_East'];
    $design_co_North = $_POST['design_co_North'];
    $design_co_East = $_POST['design_co_East'];
    $date = $_POST['date'];
    $machine_type = $_POST['machine_type'];
    $ground_level = $_POST['ground_level'];
    $ctl = $_POST['ctl'];
    $col = $_POST['col'];
    $pile_status = $_POST['pile_status'];

    $selectedProject = $_SESSION['selectedProject'];

    // Check if the pile already exists for the selected project
    $check_query = "SELECT * FROM pile WHERE pile_number = '$pile_number' AND fk_project_id = '$selectedProject'";
    $check_result = mysqli_query($connection, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // Pile already exists for the selected project
        $_SESSION['status'] = "<b style='color:red;'>Pile already exists for this project.</b>";
        $_SESSION['status_code'] = "error";
        header('Location: pile_register.php');
        exit(); // Stop further execution
    }

    // If pile does not exist, insert it into the database
    $query = "INSERT INTO 
        pile (pile_number, pile_location, actual_co_North, actual_co_East, design_co_North, design_co_East, date, machine_type, ground_level, ctl, col, pile_status, fk_project_id) 
        VALUES ('$pile_number', '$pile_location', '$actual_co_North', '$actual_co_East', '$design_co_North', '$design_co_East', '$date', '$machine_type', '$ground_level', '$ctl', '$col', '$pile_status', '$selectedProject')";

    $query_run = mysqli_query($connection, $query);

    if($query_run) {
        $_SESSION['status'] = "Pile Profile Added";
        $_SESSION['status_code'] = "success";
        header('Location: pile_register.php');
    } else {
        $_SESSION['status'] = "Pile Profile Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: pile_register.php');  
    }
}


if(isset($_POST['pile_update_btn']))
{
    echo "Hi";
    $id =$_POST['pile_edit_id'];
    $pile_number = $_POST['pile_number'];
    $pile_location = $_POST['pile_location'];
    $actual_co_North = $_POST['actual_co_North'];
    $actual_co_East = $_POST['actual_co_East'];
    $design_co_North = $_POST['design_co_North'];
    $design_co_East = $_POST['design_co_East'];
    $date = $_POST['date'];
    $machine_type = $_POST['machine_type'];
    $ground_level = $_POST['ground_level'];
    $ctl = $_POST['ctl'];
    $col = $_POST['col'];
    $pile_status = $_POST['pile_update_status'];

    $query = "UPDATE pile SET 
            pile_number='$pile_number', 
            pile_location='$pile_location', 
            actual_co_North='$actual_co_North', 
            actual_co_East='$actual_co_East', 
            design_co_North='$design_co_North', 
            design_co_East='$design_co_East', 
            date='$date', 
            machine_type='$machine_type', 
            ground_level='$ground_level', 
            ctl='$ctl', 
            col='$col', 
            pile_status ='$pile_status'
          WHERE id='$id'";

    $query_run = mysqli_query($connection, $query);
    if($query_run)
    {
        $_SESSION['status'] = "Your Pile record is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: pile_register.php');
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: pile_register.php'); 
    }
}



if(isset($_POST['pile_delete_btn']))
{
    $id =$_POST['pile_delete_id'];

    $query = "DELETE FROM pile WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Pile is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: pile_register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Pile is NOT Deleted";       
        $_SESSION['status_code'] = "error";
        header('Location: pile_register.php'); 
    } 
}

?>