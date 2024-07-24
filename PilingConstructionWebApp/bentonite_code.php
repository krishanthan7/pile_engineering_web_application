<?php 
session_start();
$connection = mysqli_connect('localhost','root','','finalresearch');

if(isset($_POST['addbentonite_btn']))
{
    $stage = $_POST['stage'];
    $density = $_POST['density'];
    $viscosity = $_POST['viscosity'];
    $ph = $_POST['ph'];
    $sand_content = $_POST['sand_content'];
    $time = $_POST['time'];

    $selectedPile = $_SESSION['selectedPile'];
    echo $selectedPile;



    $query = "INSERT INTO 
    bentonite (stage, density, viscosity, ph, sand_content, time,fk_pile_id
    ) 
    VALUES ('$stage', '$density', '$viscosity', '$ph', '$sand_content', '$time','$selectedPile'
    )";

    $query_run = mysqli_query($connection, $query);
    if($query_run)
    {
        // echo "Saved";
        $_SESSION['status'] = "Bentonite Profile Added";
        $_SESSION['status_code'] = "success";
        header('Location: bentonite_register.php');
    }
    else 
    {
        $_SESSION['status'] = "Bentonite Profile Not Added";
        $_SESSION['status_code'] = "error";
         header('Location: bentonite_register.php');  
    }
    
}



if(isset($_POST['bentonite_update_btn']))
{
    $id = $_POST['bentonite_edit_id'];
    $stage = $_POST['stage'];
    $density = $_POST['density'];
    $viscosity = $_POST['viscosity'];
    $ph = $_POST['ph'];
    $sand_content = $_POST['sand_content'];
    $time = $_POST['time'];

    $query = "UPDATE bentonite SET 
            stage='$stage', 
            density='$density', 
            viscosity='$viscosity', 
            ph='$ph', 
            sand_content='$sand_content', 
            time='$time'
             
          WHERE id='$id'";

    $query_run = mysqli_query($connection, $query);
    if($query_run)
    {
        $_SESSION['status'] = "Your Bentonite record is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: bentonite_register.php');
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: bentonite_register.php'); 
    }
}


if(isset($_POST['bentonite_delete_btn']))
{
    $id =$_POST['bentonite_delete_id'];
    $query = "DELETE FROM bentonite WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Bentonite profile is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: bentonite_register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: bentonite_register.php'); 
    } 
}
?>