<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $announcementID = $_POST['announcementID'];
    $title = $_POST['title'];
    $categoryID = $_POST['categoryID'];
    $postedBy = $_POST['postedBy'];
    $postedDate = $_POST['postedDate'];
    $attachmentPath = $_FILES['attachment']['name'];
    $attachmentType = $_POST['attachmentType'];

    // Validate input
    if (empty($title) || empty($categoryID) || empty($postedBy) || empty($postedDate)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Handle file upload
    if ($attachmentPath) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["attachment"]["name"]);

        // Check if file upload was successful
        if ($_FILES['attachment']['error'] !== UPLOAD_ERR_OK) {
            echo "Error uploading file.";
            exit;
        }

        // Move the file
        if (!move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
            echo "Error moving file.";
            exit;
        }
    }

    // Prepare SQL query
    $sql = "UPDATE Announcements SET Title=?, CategoryID=?, PostedBy=?, PostedDate=?, AttachmentType=? WHERE AnnouncementID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $title, $categoryID, $postedBy, $postedDate, $attachmentType, $announcementID);

    // Update attachment path if a new file was uploaded
    if ($attachmentPath) {
        $stmt->close();
        $sql = "UPDATE Announcements SET AttachmentPath=? WHERE AnnouncementID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $target_file, $announcementID);
    }

    // Execute SQL query
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Announcement updated successfully. <a href='announcementview.php'>Announcement view</a>";
    }

    $stmt->close();
    $conn->close();
} else {
    $announcementID = $_GET['id'];
    $sql = "SELECT * FROM Announcements WHERE AnnouncementID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $announcementID);
    $stmt->execute();
    $result = $stmt->get_result();
    $announcement = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Announcement</title>
</head>
<body>
    <h1>Edit Announcement</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="announcementID" value="<?php echo $announcement['AnnouncementID']; ?>">
        Title: <input type="text" name="title" value="<?php echo $announcement['Title']; ?>" required><br>
        Category:
        <select name="categoryID">
            <?php
            $category_sql = "SELECT * FROM AnnouncementCategories";
            $stmt = $conn->prepare($category_sql);
            $stmt->execute();
            $categories = $stmt->get_result();
            while ($row = $categories->fetch_assoc()) {
                echo "<option value='" . $row["CategoryID"] . "'" . ($row["CategoryID"] == $announcement['CategoryID'] ? ' selected' : '') . ">" . $row["CategoryName"] . "</option>";
            }
            $stmt->close();
            ?>
        </select><br>
        Posted By:
        <select name="postedBy">
            <?php
            $user_sql = "SELECT * FROM Users";
