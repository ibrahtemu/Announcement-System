<?php
include 'connection.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $announcementID = intval($_GET['id']);

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM Announcements WHERE AnnouncementID = ?");
    $stmt->bind_param("i", $announcementID);

    if ($stmt->execute()) {
        // Redirect to the view announcements page after deletion
        header("Location: view_announcements.php?msg=Announcement deleted successfully.");
        exit();
    } else {
        echo "Error deleting announcement: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No ID specified.";
}

$conn->close();
?>
