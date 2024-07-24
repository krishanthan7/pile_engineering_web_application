<?php
session_start();

$connection = mysqli_connect('localhost','root','','finalresearch');

if(isset($_POST['registerbtn'])) {
    $username = $_POST['username'];
    $nic = $_POST['nic'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];
    $usertype = $_POST['usertype'];

    // Check if the NIC already exists in the database
    $check_query = "SELECT * FROM registerintern WHERE nic = '$nic'";
    $check_result = mysqli_query($connection, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // NIC already exists in the database
        $_SESSION['status'] = "<b style='color:red;'>User with same NIC number already exists.</b>";
        $_SESSION['status_code'] = "error";
        header('Location: register.php');
        exit(); // Stop further execution
    }

    // Check if passwords match
    if($password === $cpassword) {
        // If passwords match, insert the user into the database
        $query = "INSERT INTO registerintern (username, nic, mobile, email, password, usertype) 
                  VALUES ('$username', '$nic', '$mobile', '$email', '$password', '$usertype')";
        $query_run = mysqli_query($connection, $query);

        if($query_run) {
            $_SESSION['status'] = "Intern Profile Added";
            $_SESSION['status_code'] = "success";
            header('Location: register.php');
        } else {
            $_SESSION['status'] = "Intern Profile Not Added";
            $_SESSION['status_code'] = "error";
            header('Location: register.php');  
        }
    } else {
        // Passwords do not match
        $_SESSION['status'] = "Password and Confirm Password Does Not Match";
        $_SESSION['status_code'] = "warning";
        header('Location: register.php');  
    }
}



if(isset($_POST['updatebtn']))
{
    $id =$_POST['edit_id'];
    $username = $_POST['edit_username'];
    $nic = $_POST['edit_nic'];
    $mobile = $_POST['edit_mobile'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];
    $usertypeupdate = $_POST['update_usertype'];

    $query = "UPDATE registerintern SET username='$username', nic='$nic' , mobile='$mobile',email='$email', password='$password', usertype='$usertypeupdate' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);


    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: register.php');
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    }
}

if(isset($_POST['delete_btn']))
{
    $id =$_POST['delete_id'];

    $query = "DELETE FROM registerintern WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    } 
}


if(isset($_POST['login_btn']))
{
    $email_login = $_POST['email'];
    $password_login = $_POST['password'];

    $query = "SELECT * FROM registerintern WHERE email='$email_login' AND password = '$password_login' ";
    $query_run = mysqli_query($connection, $query);
    
    $usertypes = mysqli_fetch_array($query_run);
    //print_r($usertypes);

    if($usertypes['usertype'] == "admin")
    {
        
        $_SESSION['username'] =  $email_login;
        echo 'admin';
        header('Location: index.php');
    }
    else if($usertypes['usertype'] == "Intern")
    {
        $_SESSION['username'] =  $email_login;
        echo 'intern';
        header('Location: intern_index.php');
    }
    else{
        //print_r($query_run); 
        $_SESSION['status'] =  'Email id or Password is not valid';
        //echo $usertypes['usertype'];
        header('Location: login.php');

    }


}    




?>
