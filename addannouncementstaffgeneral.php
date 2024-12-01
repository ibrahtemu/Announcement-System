<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if categoryID is set
    if (isset($_POST['categoryID'])) {
        $categoryID = intval($_POST['categoryID']);
    } else {
        die("Category ID not set.");
    }

    // Sanitize other form inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $postedBy = intval($_POST['postedBy']);
    $postedDate = mysqli_real_escape_string($conn, $_POST['postedDate']);
    $attachmentType = mysqli_real_escape_string($conn, $_POST['attachmentType']);

    // Handle file upload
    $target_file = '';
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['attachment']['tmp_name'];
        $fileName = basename($_FILES['attachment']['name']);
        $fileName = preg_replace('/[^a-zA-Z0-9\.\-_]/', '_', $fileName); // Sanitize file name
        $target_dir = "uploads/";
        $target_file = $target_dir . $fileName;

        // Check if the directory exists
        if (!is_dir($target_dir)) {
            echo "Directory does not exist. Attempting to create it.<br>";
            if (!mkdir($target_dir, 0755, true)) {
                die("Failed to create directory.<br>");
            }
        }

        // Check if the file type is allowed
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($fileTmpPath, $target_file)) {
                echo "File uploaded successfully.<br>";
            } else {
                echo "Failed to move uploaded file.<br>";
            }
        } else {
            echo "Invalid file type.<br>";
        }
    } elseif (isset($_FILES['attachment']) && $_FILES['attachment']['error'] != UPLOAD_ERR_NO_FILE) {
        echo "File upload error: " . $_FILES['attachment']['error'] . "<br>";
    }

    // Determine the table name based on the category selection
    $tableName = '';
    switch ($categoryID) {
        case 1:
            $tableName = 'announcements';
            break;
        case 2:
            $tableName = 'civildept';
            break;
        case 3:
            $tableName = 'mechanicaldept';
            break;
        case 4:
            $tableName = 'computerdept';
            break;
        case 5:
            $tableName = 'electr_dept';
            break;
        case 6:
            $tableName = 'ditso';
            break;
        case 7:
            $tableName = 'heslb';
            break;
        case 8:
            $tableName = 'telecom_dept';
            break;
        case 9:
            $tableName = 'sci_lab_tech';
            break;
        case 10:
            $tableName = 't_factory';
            break;
        case 11:
            $tableName = 'extra';
            break;
        default:
            die("Invalid category selected.");
    }

    // Prepare and execute the SQL statement for the correct table
    $stmt = $conn->prepare("INSERT INTO $tableName (Title, Description, CategoryID, PostedBy, PostedDate, AttachmentPath, AttachmentType) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssissss", $title, $description, $categoryID, $postedBy, $postedDate, $target_file, $attachmentType);

    if ($stmt->execute()) {
        echo "New announcement added successfully. <a href='view_announcements.php'>View Announcements</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Announcement</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="loading.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
        }
        .btn-primary {
            background-color: #337ab7;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #23527c;
        }
    </style>
</head>
<body>
    <header>
    <h1>Add New Announcement</h1>
    </header>
    <div class="container">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <div>
            <div class="form-group">
               <label for="categoryID">Category:</label>
               <select class="form-control" id="categoryID" name="categoryID">
                    <option value="1">General Announcements</option>
                    <!--<option value="2">Civil Department</option>
                   <option value="3">Mechanical Department</option>
                   <option value="4">Computer Department</option>
                   <option value="5">Electrical Department</option>
                   <option value="6">DITSO</option>
                   <option value="7">HESLB</option>
                   <option value="8">Telecom Department</option>
                   <option value="9">Laboratory Department</option>
                   <option value="10">Teaching Factory</option>
                   <option value="11">Extra</option>-->
              </select>
        </div>

            </div>
            <div class="form-group">
                <label for="postedBy">Posted By:</label>
                <select class="form-control" id="postedBy" name="postedBy">
                    <?php
                    $user_sql = "SELECT * FROM Users";
                    $users = $conn->query($user_sql);
                    while ($row = $users->fetch_assoc()) {
                        echo "<option value='" . $row["UserID"] . "'>" . $row["Username"] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="postedDate">Posted Date:</label>
                <input type="datetime-local" class="form-control" id="postedDate" name="postedDate" required>
            </div>
            <div class="form-group">
                <label for="attachment">Attachment:</label>
                <input type="file" class="form-control" id="attachment" name="attachment">
            </div>
            <div class="form-group">
                <label for="attachmentType">Attachment Type:</label>
                <select class="form-control" id="attachmentType" name="attachmentType">
                    <option value="image">Image</option>
                    <option value="pdf">PDF</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary ld-ext-left"
            onclick="this.classList.toggle('running')">
            Add Announcement
            <div class="ld ld-ring ld-spin"></div></button>
            <!--<div class="btn btn-primary ld-ext-right"
onclick="this.classList.toggle('running')">
  Clike Me
  <div class="ld ld-ring ld-spin"></div>
</div>-->
        </form>
        <a href="view_announcements.php" class="btn btn-secondary mt-3">Back to Announcements List</a>
    </div>
    <footer>
        <p>&copy; 2024 Announcement Platform</p>
    </footer></div>

</body>
</html>




