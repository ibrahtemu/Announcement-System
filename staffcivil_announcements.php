<?php
include 'connection.php';

$sql = "SELECT civildept.AnnouncementID, civildept.Title, AnnouncementCategories.CategoryName, civildept.PostedBy, civildept.PostedDate, civildept.AttachmentPath, civildept.AttachmentType, Users.Username 
        FROM civildept
        JOIN AnnouncementCategories ON civildept.CategoryID = AnnouncementCategories.CategoryID 
        JOIN Users ON civildept.PostedBy = Users.UserID
        ORDER BY civildept.PostedDate DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <h1>Civil <br>Announcements</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Announcement Platform</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <a class="dropdown-item" href="view_announcements.php?category=computer">Computer Science</a>
                            <a class="dropdown-item" href="view_announcements.php?category=math">Mathematics</a>
                            <a class="dropdown-item" href="view_announcements.php?category=science">Science</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="view_all_announcements.php">All Announcements</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search Announcements" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userActionsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            User Actions
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userActionsDropdown">
                            <a class="dropdown-item" href="addannouncementstaffcomputer.php">Add Announcement</a>
                            <a class="dropdown-item" href="my_announcements.php">My Announcements</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="grid-container">

            <a href="addannouncementstaffcivil.php" class="add-announcement">+</a>

            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='grid-item'>";
                    
                    
                    if ($row["AttachmentPath"] && $row["AttachmentType"] == 'image') {
                        echo "<img src='" . $row["AttachmentPath"] . "' alt='Announcement Image'>";
                    } else {
                        echo "<img src='placeholder.png' alt='No Image Available'>";
                    }

                   
                    echo "<h3>" . $row["Title"] . "</h3>";
                    echo "<p><strong>Date:</strong> " . $row["PostedDate"] . "</p>";

                  
                    echo "<div class='actions'>
                        <a href='announcementpage.php?id=" . $row["AnnouncementID"] . "' class='btn btn-sm btn-primary'>View</a>
                        <a href='edit.php?id=" . $row["AnnouncementID"] . "' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='delete.php?id=" . $row["AnnouncementID"] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this announcement?');\">Delete</a>
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