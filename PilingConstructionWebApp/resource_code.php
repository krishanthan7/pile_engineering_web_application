<?php 
session_start();
$connection = mysqli_connect('localhost','root','','finalresearch');

if(isset($_POST['addresource_btn'])) {
    $name = $_POST['resource_name'];
    $qty = $_POST['qty'];
    $cost = $_POST['cost'];
    $selectedProject = $_SESSION['selectedProject'];

    // Check if the resource already exists for the selected project
    $check_query = "SELECT * FROM resource WHERE name = '$name' AND fk_project_id = '$selectedProject'";
    $check_result = mysqli_query($connection, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // Resource already exists for the selected project
        $_SESSION['status'] = "<b style='color:red;'> Resource already exists for this project. </b>";
        $_SESSION['status_code'] = "error";
        header('Location: resource_register.php');
        exit(); // Stop further execution
    }

    // If resource does not exist, insert it into the database
    $insert_query = "INSERT INTO resource (name, qty, cost, fk_project_id) 
                     VALUES ('$name', '$qty', '$cost', '$selectedProject')";
    $query_run = mysqli_query($connection, $insert_query);

    if($query_run) {
        $_SESSION['status'] = "Resource Profile Added";
        $_SESSION['status_code'] = "success";
        header('Location: resource_register.php');
    } else {
        $_SESSION['status'] = "Resource Profile Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: resource_register.php');  
    }
}


if(isset($_POST['resource_update_btn']))
{
    
    $id =$_POST['resource_edit_id'];
    $name =$_POST['edit_resource_name'];
    $qty =$_POST['edit_qty'];
    $cost =$_POST['edit_cost'];


    $query = "UPDATE resource SET 
    name = '$name' ,qty = '$qty',cost ='$cost' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);


    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: resource_register.php');
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: resource_register.php'); 
    }
}
if(isset($_POST['resource_delete_btn']))
{
    $id =$_POST['resource_delete_id'];
    $query = "DELETE FROM resource WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: resource_register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: resource_register.php'); 
    } 
}



?>