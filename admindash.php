<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginpage.php");
    exit();
}

// Example database connection for dynamic stats (update with your details)
$conn = new mysqli('localhost', 'root', '', 'announce');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch dynamic stats (replace table names as needed)
$student_count = $conn->query("SELECT COUNT(*) AS count FROM students")->fetch_assoc()['count'] ?? 0;
$staff_count = $conn->query("SELECT COUNT(*) AS count FROM staff")->fetch_assoc()['count'] ?? 0;
$announcement_count_1 = $conn->query("SELECT COUNT(*) AS count FROM announcements")->fetch_assoc()['count'] ?? 0;
$announcement_count_2 = $conn->query("SELECT COUNT(*) AS count FROM civildept")->fetch_assoc()['count'] ?? 0;
$announcement_count_3 = $conn->query("SELECT COUNT(*) AS count FROM mechanicaldept")->fetch_assoc()['count'] ?? 0;
$announcement_count_4 = $conn->query("SELECT COUNT(*) AS count FROM electr_dept")->fetch_assoc()['count'] ?? 0;
$announcement_count_5 = $conn->query("SELECT COUNT(*) AS count FROM sci_lab_tech")->fetch_assoc()['count'] ?? 0;
$announcement_count_6 = $conn->query("SELECT COUNT(*) AS count FROM ditso")->fetch_assoc()['count'] ?? 0;
$announcement_count_7 = $conn->query("SELECT COUNT(*) AS count FROM computerdept")->fetch_assoc()['count'] ?? 0;
$announcement_count_8 = $conn->query("SELECT COUNT(*) AS count FROM heslb")->fetch_assoc()['count'] ?? 0;
$announcement_count_9 = $conn->query("SELECT COUNT(*) AS count FROM extra")->fetch_assoc()['count'] ?? 0;
$announcement_count_10 = $conn->query("SELECT COUNT(*) AS count FROM t_factory")->fetch_assoc()['count'] ?? 0;
$announcement_count_11 = $conn->query("SELECT COUNT(*) AS count FROM telecom_dept")->fetch_assoc()['count'] ?? 0;

$total_announcement_count = $announcement_count_1 + $announcement_count_2 + $announcement_count_3 + $announcement_count_4 +
                            $announcement_count_5 + $announcement_count_6 + $announcement_count_7 + $announcement_count_8 +
                            $announcement_count_9 + $announcement_count_10 + $announcement_count_11;


// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        header {
            background-color: #0e5769;
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        footer {
            width: 100%;
            position: fixed;
            padding: 15px;
            bottom: 0;
            text-align: center;
            justify-content: center;
            left: 0px;
        }

      
    </style>
</head>
<body>

    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <nav class="navbar">
    <div class="logo">
        <a href="dashboard.php">Admin Panel</a>
    </div>
    <ul class="nav-links">
        <li><a href="dashboard.php" class="active">Dashboard</a></li>
        <li class="dropdown">
            <a href="#">Manage Users ▼</a>
            <ul class="dropdown-menu">
                <li><a href="register_staff.php">Register Staff</a></li>
                <li><a href="register_student.php">Register Student</a></li>
                <li><a href="view_users.php">View All Users</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#">Announcements ▼</a>
            <ul class="dropdown-menu">
                <li><a href="add_announcement.php">Add Announcement</a></li>
                <li><a href="view_announcements.php">View Announcements</a></li>
            </ul>
        </li>
        <li><a href="view_logs.php">Logs</a></li>
        <li><a href="logoutpage.php" class="logout">Logout</a></li>
    </ul>
</nav>


    <div class="dashboard-container">
        <h2>Welcome, Admin!</h2>

        <div class="dashboard-section">
            <h3 class="section-header">Quick Stats</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <h4>Total Students</h4>
                    <p><?php echo $student_count; ?></p>
                </div>
                <div class="stat-item">
                    <h4>Total Staff</h4>
                    <p><?php echo $staff_count; ?></p>
                </div>
                <div class="stat-item">
                    <h4>Announcements</h4>
                    <p><?php echo $total_announcement_count; ?></p>
                </div>
            </div>
        </div>

        <!-- Manage Users 
        <div class="dashboard-section">
            <h3 class="section-header">Manage Users</h3>
            <div class="dashboard-links">
                <a href="register_staff.php">Register Staff</a>
                <a href="register_student.php">Register Student</a>
                <a href="view_users.php">View All Users</a>
            </div>
        </div>
    </div> -->


    
    <footer>
        <p>&copy; 2024 Announcement Platform</p>
    </footer>
</body>
</html>
