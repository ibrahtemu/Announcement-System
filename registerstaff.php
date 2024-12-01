<?php
// Start a secure session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Ensure HTTPS is used
ini_set('session.use_strict_mode', 1);
session_start();

// Enforce HTTPS (optional, based on your development setup)
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    // Uncomment the following lines if you have HTTPS set up locally
    /*
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect); 
    exit();
    */
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Include Database Connection
include 'connection.php';

// Initialize variables
$error = '';
$success = '';

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Invalid CSRF token.";
    } else {
        // Retrieve and sanitize inputs
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $department = trim($_POST['department']);

        // Validation
        if (empty($username) || empty($password) || empty($confirm_password) || empty($department)) {
            $error = "Please fill in all fields.";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            // Password must be at least 8 characters long and include both letters and numbers
            $error = "Password must be at least 8 characters long and include both letters and numbers.";
        } else {
            // Check if username already exists
            $stmt = $conn->prepare("SELECT UserID FROM Users WHERE Username = ?");
            if ($stmt === false) {
                $error = "Prepare failed: " . htmlspecialchars($conn->error);
            } else {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $error = "Username already taken.";
                } else {
                    // Get DepartmentID from Departments table
                    $deptStmt = $conn->prepare("SELECT DepartmentID FROM Departments WHERE DepartmentName = ?");
                    if ($deptStmt === false) {
                        $error = "Prepare failed: " . htmlspecialchars($conn->error);
                    } else {
                        $deptStmt->bind_param("s", $department);
                        $deptStmt->execute();
                        $deptStmt->bind_result($departmentID);
                        $deptStmt->fetch();
                        $deptStmt->close();

                        if (!$departmentID) {
                            $error = "Selected department does not exist.";
                        } else {
                            // Hash the password
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                            // Insert new staff user into Users table
                            $insertStmt = $conn->prepare("INSERT INTO Users (Username, Password, UserRole, DepartmentID, CreatedAt) VALUES (?, ?, 'staff', ?, NOW())");
                            if ($insertStmt === false) {
                                $error = "Prepare failed: " . htmlspecialchars($conn->error);
                            } else {
                                $insertStmt->bind_param("ssi", $username, $hashedPassword, $departmentID);
                                if ($insertStmt->execute()) {
                                    $_SESSION['success'] = "Staff registration successful. You can now log in.";
                                    header("Location: loginpage.php");
                                    exit();
                                } else {
                                    $error = "Registration failed. Please try again.";
                                }
                                $insertStmt->close();
                            }
                        }
                    }
                }
                $stmt->close();
            }
        }
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* Styles for demonstration purposes */
        body {
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .register-container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 400px;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group select[name="department"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        } 
    </style>
</head>
<body class="body">
    <header>
        <h1>Register Staff</h1>
    </header>
    <div class="container">
    <div class="register-container">
        <h2>Register as Staff</h2>
        <form action="register.php" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            
            <!-- Display Error Message -->
            <?php 
            if (!empty($error)) { 
                echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>"; 
            } 
            ?>

            <!-- Display Success Message -->
            <?php 
            if (!empty($success)) { 
                echo "<p class='success-message'>" . htmlspecialchars($success) . "</p>"; 
            } 
            ?>

            <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password"><b>Password</b></label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="confirm_password"><b>Confirm Password</b></label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required autocomplete="new-password">
            </div>

            <!--<div class="form-group">
                <label for="department"><b>Department</b></label>
                <select name="department" id="department" required>
                    <option value="">Select Department</option>
                    <?php
                    // Fetch departments from the database
                    $deptQuery = "SELECT DepartmentName FROM Departments ORDER BY DepartmentName ASC";
                    $deptResult = $conn->query($deptQuery);
                    if ($deptResult->num_rows > 0) {
                        while ($row = $deptResult->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['DepartmentName']) . "'>" . htmlspecialchars($row['DepartmentName']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>-->

            <button type="submit" class="submit-btn">Register</button>

            <div class="login-link">
                <p>Already have an account? <a href="loginpage.php">Login here</a>.</p>
            </div>
        </form>
    </div>
    </div>
    <footer>
    <p>&copy; 2024 Announcement Platform</p>
    </footer>
</body>
</html>