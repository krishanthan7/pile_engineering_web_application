<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'finalresearch');

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Retrieve the selected project ID from session
$selectedProject = isset($_SESSION['selectedProject']) ? $_SESSION['selectedProject'] : '';

if(isset($_POST['addmaterial_btn'])) {
    // Retrieve form data
    $material_name = $_POST['material_name'];
    $color = $_POST['color'];
    $remarks = $_POST['remarks'];
    $material_status = $_POST['material_status'];

    // File upload handling
    $target_dir = "uploads/"; // Specify the directory where uploaded files will be stored
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["addresource_btn"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['status'] = "File is not an image.";
            $_SESSION['status_code'] = "error";
            header('Location: soilref_register.php');
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $_SESSION['status'] = "Sorry, your file is too large.";
        $_SESSION['status_code'] = "error";
        header('Location: soilref_register.php');
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $_SESSION['status'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $_SESSION['status_code'] = "error";
        header('Location: soilref_register.php');
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['status'] = "Sorry, your file was not uploaded.";
        $_SESSION['status_code'] = "error";
        header('Location: soilref_register.php');
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Image upload successful, proceed to insert data into the database
            
            // SQL query to insert data into materials table
            $query = "INSERT INTO material (material_name, color, remarks, image_path, fk_project_id)
                    VALUES ('$material_name', '$color', '$remarks', '$target_file', '$selectedProject')";

            $query_run = mysqli_query($connection, $query);
            if($query_run) {
                $_SESSION['status'] = "Material Profile Added";
                $_SESSION['status_code'] = "success";
                header('Location: soilref_register.php');
            } else {
                $_SESSION['status'] = "Material Profile Not Added";
                $_SESSION['status_code'] = "error";
                header('Location: soilref_register.php');
            }
            
        } else {
            $_SESSION['status'] = "Sorry, there was an error uploading your file.";
            $_SESSION['status_code'] = "error";
            header('Location: soilref_register.php');
        }
    }
}






if (isset($_POST['soilref_update_btn'])) {
    $id = $_POST['soilref_edit_id'];
    $name = $_POST['edit_soilref_name'];
    $color = $_POST['edit_color'];
    $remarks = $_POST['edit_remarks'];

    // Check if a new image file is uploaded
    if ($_FILES["edit_image"]["error"] == 0) {
        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["edit_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES["edit_image"]["size"] > 500000) {
            $_SESSION['status'] = "Sorry, your file is too large.";
            $_SESSION['status_code'] = "error";
            header('Location: soilref_register.php');
            exit();
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['status'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $_SESSION['status_code'] = "error";
            header('Location: soilref_register.php');
            exit();
        }

        // Move uploaded file to target directory
        if (!move_uploaded_file($_FILES["edit_image"]["tmp_name"], $target_file)) {
            $_SESSION['status'] = "Sorry, there was an error uploading your file.";
            $_SESSION['status_code'] = "error";
            header('Location: soilref_register.php');
            exit();
        }

        // Update image path in database
        $image_path = $target_file;
    } else {
        // No new file uploaded, keep existing image path
        $image_path = $_POST['edit_image']; // Assuming this is the current image path in the database
    }

    // Update other fields and image path in database
    $query = "UPDATE material SET material_name = '$name', color = '$color', remarks = '$remarks', image_path = '$image_path' WHERE id = '$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['status'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
    }
    header('Location: soilref_register.php');
    exit();
}

if(isset($_POST['soilref_delete_btn']))
{
    $id = $_POST['soilref_delete_id'];
    $query = "DELETE FROM material WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: soilref_register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: soilref_register.php'); 
    } 
}

mysqli_close($connection); // Close the database connection
?>
