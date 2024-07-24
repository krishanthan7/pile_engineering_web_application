<?php
include ('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 

//session_start(); // Start the session - Check if this is needed here

// Include database configuration
include 'dbconfig.php'; 


?>



<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="font-size: 20px;">About Our Project</h6>
        </div>
        <div class="card-body text-center" style="font-size: 20px;">
            <img src="img/about.png" class="img-fluid mb-2 mx-auto d-block" alt="about" style="max-width: 200px;">
            <p class="text-center">Our project aims to revolutionize piling project management through digital transformation. Traditional practices in this field often pose challenges in accessibility and usability. To address this, we're developing a web application that streamlines construction practices, particularly in piling projects. This digital solution simplifies tasks, facilitates data transfer and storage, and enhances overall efficiency. Our goal is to create a flexible and adaptable solution accessible from any location, catering to the dynamic needs of the construction industry.</p>
        </div>
    </div>
</div>



<?php
include('includes/scripts.php');
include('includes/footer.php');
?>