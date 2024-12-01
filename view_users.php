<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginpage.php");
    exit();
}

include 'connection.php'; // Ensure this file connects to your database

// Fetch users from the database
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View Users</title>
</head>
<body>
    <header>
    <h1>View All Users</h1>
    </header>
    <div class="container">
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Password</th>
                <th>Role</th>
                <th>Department</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['UserID']; ?></td>
                    <td><?php echo $row['Username']; ?></td>
                    <td><?php echo $row['Password']; ?></td>
                    <td><?php echo $row['UserRole']; ?></td>
                    <td><?php echo $row['Department']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
    <footer><p>&copy; 2024 Announcement Platform.</p></footer>
</body>
</html>
