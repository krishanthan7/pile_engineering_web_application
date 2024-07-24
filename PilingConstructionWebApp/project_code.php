<?php 
session_start();
$connection = mysqli_connect('localhost','root','','finalresearch');

if(isset($_POST['addproject_btn'])) {

    $project_code = $_POST['project_code'];
    $project_name = $_POST['project_name'];
    $location = $_POST['location'];
    $cost = $_POST['cost'];
    $client = $_POST['client'];
    $consultant = $_POST['consultant'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $duration = $_POST['duration'];
    $pilecount = $_POST['pilecount'];
    $assigned_pm = $_POST['assigned_pm'];
    $assigned_engr = $_POST['assigned_engr'];
    $project_status = $_POST['project_status'];

    // Check if a project with the same project code or project name already exists
    $check_query = "SELECT * FROM project WHERE project_code = '$project_code' OR project_name = '$project_name'";
    $check_result = mysqli_query($connection, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // Project with the same project code or project name already exists
        $_SESSION['status'] = "<b style='color:red;'>Project with the same project code or project name already exists.</b>";
        $_SESSION['status_code'] = "error";
        header('Location: project_register.php');
        exit(); // Stop further execution
    }

    // If no duplicate project is found, insert the new project into the database
    $query = "INSERT INTO 
    project (project_code,project_name,location,cost,client,consultant,
    start_date,end_date,duration,pilecount,assigned_pm,assigned_engr,project_status
    ) 
    VALUES ('$project_code','$project_name','$location','$cost','$client','$consultant',
    '$start_date','$end_date','$duration','$pilecount','$assigned_pm','$assigned_engr','$project_status'
    )";
    $query_run = mysqli_query($connection, $query);

    if($query_run) {
        $_SESSION['status'] = "Project Profile Added";
        $_SESSION['status_code'] = "success";
        header('Location: project_register.php');
    } else {
        $_SESSION['status'] = "Project Profile Not Added";
        $_SESSION['status_code'] = "error";
        header('Location: project_register.php');  
    }
}

if(isset($_POST['project_update_btn']))
{
    
    $id =$_POST['project_edit_id'];
    $project_code =$_POST['edit_project_code'];
    $project_name =$_POST['edit_project_name'];
    $location =$_POST['edit_location'];
    $cost =$_POST['edit_cost'];
    $client =$_POST['edit_client'];
    $consultant =$_POST['edit_consultant'];
    $start_date =$_POST['edit_start_date'];
    $end_date =$_POST['edit_end_date'];
    $duration =$_POST['edit_duration'];
    $pilecount =$_POST['edit_pilecount'];
    $assigned_pm =$_POST['edit_assigned_pm'];
    $assigned_engr =$_POST['edit_assigned_engr'];
    $projectstatus =$_POST['update_projectstatus'];


    $query = "UPDATE project SET 
    project_code = '$project_code' ,project_name = '$project_name',location = '$location' ,cost ='$cost' ,client = '$client' ,consultant = '$consultant',
    start_date = '$start_date' ,end_date = '$end_date' ,duration = '$duration' ,pilecount = '$pilecount' ,assigned_pm = '$assigned_pm' ,assigned_engr = '$assigned_engr' ,project_status = '$projectstatus' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);


    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: project_register.php');
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: project_register.php'); 
    }
}
if(isset($_POST['project_delete_btn']))
{
    $id =$_POST['project_delete_id'];
    $query = "DELETE FROM project WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: project_register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: project_register.php'); 
    } 
}


if(isset($_POST['project_delete_btn']))
{
    $id =$_POST['project_delete_id'];

    $query = "DELETE FROM project WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Project is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: project_register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Project is NOT Deleted";       
        $_SESSION['status_code'] = "error";
        header('Location: project_register.php'); 
    } 
}
?>