<?php 
session_start();
$connection = mysqli_connect('localhost','root','','finalresearch');

if(isset($_POST['addprocess_btn']))
{

    $tool = $_POST['tool'];
    $depth_from = $_POST['depth_from'];
    $depth_to = $_POST['depth_to'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $identification = $_POST['identification'];

    $time1 = strtotime($_POST['start_time']);
    $time2 = strtotime($_POST['end_time']);
    // Calculate the difference between two times in seconds
    $difference_seconds = abs($time2 - $time1);
    // Convert seconds to minutes
    $minutes = $difference_seconds / 60;


    
    $selectedPile = $_SESSION['selectedPile'];
    echo $selectedPile;


    

    //echo $pile_number;
    $query = "INSERT INTO 
    process ( tool, depth_from,	depth_to,	start_time,	end_time,	minutes,	identification, fk_pile_id
    ) 
    VALUES ('$tool', '$depth_from', '$depth_to', '$start_time', '$end_time', '$minutes', '$identification','$selectedPile'
    )";
    
    $query_run = mysqli_query($connection, $query);
    if($query_run)
    {
        // echo "Saved";
        $_SESSION['status'] = "Process Profile Added";
        $_SESSION['status_code'] = "success";
        header('Location: process_register.php');
    }
    else 
    {
        $_SESSION['status'] = "Process Profile Not Added";
        $_SESSION['status_code'] = "error";
         header('Location: process_register.php');  
    }
    
}


if(isset($_POST['process_update_btn']))
{
    
    $id =$_POST['process_edit_id'];
    $tool = $_POST['tool'];
    $depth_from = $_POST['depth_from'];
    $depth_to = $_POST['depth_to'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];




    $time1 = strtotime($start_time);
    $time2 = strtotime($end_time);
    $difference_seconds = abs($time2 - $time1);
    $minutes = $difference_seconds / 60;



    //$minute = $_POST['minutes'];
    $identification = $_POST['identification'];


    $query = "UPDATE process SET 
    tool = '$tool' ,
    depth_from = '$depth_from',
    depth_to = '$depth_to',
    start_time = '$start_time',
    end_time = '$end_time',
    minutes = '$minutes',
    identification = '$identification'
    
    WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);


    if($query_run)
    {
        $_SESSION['status'] = "Your process is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: process_register.php');
    }
    else
    {
        $_SESSION['status'] = "Your process is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: process_register.php'); 
    }
}


if(isset($_POST['process_delete_btn']))
{
    $id =$_POST['process_delete_id'];

    $query = "DELETE FROM process WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Process is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: process_register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Process is NOT Deleted";       
        $_SESSION['status_code'] = "error";
        header('Location: process_register.php'); 
    } 
}
?>