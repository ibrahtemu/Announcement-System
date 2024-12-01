<?php
include 'connection.php';

$sql = "SELECT mechanicaldept.AnnouncementID, mechanicaldept.Title, AnnouncementCategories.CategoryName, mechanicaldept.PostedBy, mechanicaldept.PostedDate, mechanicaldept.AttachmentPath, mechanicaldept.AttachmentType, Users.Username 
        FROM mechanicaldept
        JOIN AnnouncementCategories ON mechanicaldept.CategoryID = AnnouncementCategories.CategoryID 
        JOIN Users ON mechanicaldept.PostedBy = Users.UserID
        ORDER BY mechanicaldept.PostedDate DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Flexible grid */
            gap: 20px;
        }
        .grid-item, .add-announcement {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
        }
        .grid-item:hover, .add-announcement:hover {
            transform: scale(1.05);
        }
        .grid-item img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .grid-item h3 {
            font-size: 18px;
            color: #0e5769;
            margin-bottom: 10px;
        }
        .grid-item p {
            margin: 5px 0;
            color: #333;
        }
        .actions {
            margin-top: 15px;
        }
        .actions a {
            margin-right: 10px;
        }
        /* Add Announcement Tile Styling */
        .add-announcement {
            background-color: #c3c3c3;
            color: white;
            font-size: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
        }
        .add-announcement:hover {
            background-color: #09404d;
        }
    </style>
</head>
<body>
    <header>
    <h1>Mechanical Department <br>Announcements</h1>
    </header>
    <div class="container">
        <div class="grid-container">
            <!-- Add Announcement Tile -->
            <!--<a href="addannouncement.php" class="add-announcement">+</a>-->

            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='grid-item'>";
                    
                    // Display image if AttachmentPath is present
                    if ($row["AttachmentPath"] && $row["AttachmentType"] == 'image') {
                        echo "<img src='" . $row["AttachmentPath"] . "' alt='Announcement Image'>";
                    } else {
                        // Placeholder image if no image is provided
                        echo "<img src='placeholder.png' alt='No Image Available'>";
                    }

                    // Display title, posted date, and view button
                    echo "<h3>" . $row["Title"] . "</h3>";
                    echo "<p><strong>Date:</strong> " . $row["PostedDate"] . "</p>";

                    echo "<div class='actions'>
                        <a href='announcementpage.php?id=" . $row["AnnouncementID"] . "' class='btn btn-sm btn-primary'>View</a>
                    </div>";
                    
                    echo "</div>";
                }
            } else {
                echo "<p>No announcements found</p>";
            }
            ?>
        </div>
    </div>
</body>
<footer>
<p>&copy; 2024 Announcement Platform</p>
</footer>
</html>

<?php
$conn->close();
?>