<?php
// Include your database connection code here if not already included
$connection = mysqli_connect('localhost','root','','finalresearch');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a form or button click that submits to this page

    // Update pile_status in the database
    $pile_id = 123; // Example pile_id, replace with your actual value
    $query = "UPDATE pile SET pile_status = 'Yes' WHERE pile_id = ?";
    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("i", $pile_id); // Assuming pile_id is an integer
    if ($stmt->execute()) {
        // Redirect or show success message
        header("Location: success.php"); // Redirect to a success page
        exit();
    } else {
        // Handle error
        echo "Error updating pile status: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Invalid request
    echo "Invalid request.";
}
?>
