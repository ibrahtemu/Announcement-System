<?php
include 'connection.php';

// Fetch announcements from the database
$sql = "SELECT Announcements.AnnouncementID, Announcements.Title, AnnouncementCategories.CategoryName, 
        Announcements.PostedBy, Announcements.PostedDate, Announcements.AttachmentPath, 
        Announcements.AttachmentType, Users.Username 
        FROM Announcements 
        JOIN AnnouncementCategories ON Announcements.CategoryID = AnnouncementCategories.CategoryID 
        JOIN Users ON Announcements.PostedBy = Users.UserID
        ORDER BY Announcements.PostedDate DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-pZW4XkY6kFwHLa7JiI2Eu5CBsDkZ9Vm/oWbsUqD+Urx6YZbKKI9qgx3YrVfReI/UrD8D76zzd0xFyEjfAyIU2w=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="style34.css">
    
 
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <!--<div class="sidebar-header">
            <h2>Menu</h2>
            <button class="toggle-btn"><i class="fas fa-bars"></i></button>
        </div>-->
        <ul class="nav-menu">
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-ellipsis-h"></i>
                    <span>More</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="profile.php" class="nav-link">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <!--<li>
                        <a href="settings.php" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>-->
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-bullhorn"></i>
                            <span>Other Announcements</span>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="general_announcements.php" class="nav-link">
                                    <i class="fas fa-info-circle"></i>
                                    <span>General Announcements</span>
                                </a>
                            </li>
                            <li>
                                <a href="ditso.php" class="nav-link">
                                    <i class="fas fa-project-diagram"></i>
                                    <span>DITSO</span>
                                </a>
                            </li>
                            <li>
                                <a href="heslb.php" class="nav-link">
                                    <i class="fas fa-school"></i>
                                    <span>HESLB</span>
                                </a>
                            </li>
                            <li>
                                <a href="extra.php" class="nav-link">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>EXTRA</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="logout.php" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header>
        <div class="header-content">
            <h1>Announcements</h1>
            <!--<div class="user-profile d-flex align-items-center">
                <img src="user-avatar.png" alt="User Avatar" class="rounded-circle" width="40" height="40">
                <span class="ml-2">Welcome, Username</span>
            </div>-->
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="grid-container">
                <!-- Add Announcement Tile 
                <a href="addannouncement.php" class="add-announcement" title="Add New Announcement">
                    +
                </a>-->

                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='grid-item'>";
                        
                        // Display image if AttachmentPath is present and type is image
                        if (!empty($row["AttachmentPath"]) && $row["AttachmentType"] === 'image') {
                            echo "<img src='" . htmlspecialchars($row["AttachmentPath"]) . "' alt='Announcement Image'>";
                        } else {
                            // Placeholder image if no image is provided
                            echo "<img src='placeholder.png' alt='No Image Available'>";
                        }

                        // Display title and posted date
                        echo "<h3>" . htmlspecialchars($row["Title"]) . "</h3>";
                        echo "<p><strong>Date:</strong> " . htmlspecialchars($row["PostedDate"]) . "</p>";

                        // Actions: View Button
                        echo "<div class='actions'>
                                <a href='announcementpage.php?id=" . urlencode($row["AnnouncementID"]) . "' class='btn btn-sm btn-primary'>View</a>
                              </div>";
                        
                        echo "</div>";
                    }
                } else {
                    echo "<div class='w-100 text-center'><p>No announcements found.</p></div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
     <footer>
        <p>&copy;2024; Announcement Platform</p>
     </footer>
 
    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        $(document).ready(function(){
            // Toggle Sidebar
            $('.toggle-btn').click(function(){
                $('.sidebar').toggleClass('collapsed');
                // Toggle visibility of sidebar header title
                $('.sidebar-header h2').toggle();
                // Toggle submenus if sidebar is collapsed
                if ($('.sidebar').hasClass('collapsed')) {
                    $('.nav-menu li.active > .submenu').slideUp();
                    $('.nav-menu li.active').removeClass('active');
                }
            });

            // Toggle Submenus
            $('.nav-menu .nav-link').click(function(e){
                var parentLi = $(this).parent('li');
                var submenu = $(this).next('.submenu');

                if(submenu.length){
                    e.preventDefault();
                    parentLi.toggleClass('active');
                    submenu.slideToggle();
                    parentLi.siblings('li').removeClass('active').find('.submenu').slideUp();
                }
            });
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>
