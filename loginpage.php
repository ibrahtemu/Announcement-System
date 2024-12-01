<?php
session_start();
include 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT UserID, Password, UserRole, DepartmentID FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $hashedPassword, $userRole, $departmentID);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userID'] = $userID;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $userRole;
            $_SESSION['departmentID'] = $departmentID;

            header("Location: intro.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
    <style>
      .login_content {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70vh;
        margin: 0;
    }

    footer {
        position: fixed;
    }
    </style>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <div class="login_content">
        <div class="login-container">
            <h2>Login</h2>
            <form action="loginpage.php" method="POST">
                <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
                
                <div class="form-group">
                    <label for="username"><b>Username</b></label>
                    <input type="text" id="username" name="username" placeholder="Username" required autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="password"><b>Password</b></label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>

                <button type="submit" class="submit-btn">Login</button>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                    <p class="text-center">Back to <a href="initial_page.php">Home</a></p>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer0">
        <p>&copy; 2024 Announcement Platform</p>
    </footer>
</body>
</html>
