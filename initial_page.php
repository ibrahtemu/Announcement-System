<?php
// Start the session
session_start();

// Include the database connection
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Announcement Platform</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-pZW4XkY6kFwHLa7JiI2Eu5CBsDkZ9Vm/oWbsUqD+Urx6YZbKKI9qgx3YrVfReI/UrD8D76zzd0xFyEjfAyIU2w=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    
    <style>
        /* Custom Styles */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
      
    </style>
</head>
<body>
    <!-- Navbar 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">
        <img src="assets/images/logo.png" width="30" height="30" alt="Logo">
        Announcement Platform
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>
</nav>

 Adjust Intro Section to account for fixed navbar height -->
  <header>
    <h1>Announcement System</h1>
  </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <div class="contain.er">
            <h1>Welcome to the Announcement Platform</h1>
            <p>
                Manage your announcements efficiently and stay updated with the latest information. Whether you're a student,
                admin, or a general user, our platform provides a seamless experience tailored to your needs.
            </p>
        </div>
    </section>
    
    <!-- Dashboard Section -->
    <section class="dashboard-section">
        <div class="contai.ner">
            <h2>Login to Your Account</h2>
            <div class="login-options d-flex flex-wrap justify-content-center">
                <a href="loginpage.php" class="btn btn-primary">
                    <i class="fas fa-user-graduate"></i> Login
                </a>
                <!--<a href="login/user_login.php" class="btn btn-success">
                    <i class="fas fa-user"></i> User Login
                </a>
                <a href="login/admin_login.php" class="btn btn-danger">
                    <i class="fas fa-user-shield"></i> Admin Login
                </a>-->
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Announcement Platform. All rights reserved.</p>
    </footer>
    
    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9f/ScQZf4p2FQ9p1JK9JpZop9AJd3U4I6bJ6N"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    
    <!-- Custom JavaScript -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
