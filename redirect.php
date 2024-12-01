<?php
session_start();

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['role'])) {
    header("Location: loginpage.php");
    exit();
}

$userRole = $_SESSION['role'];
$department = $_SESSION['departmentID'];

if ($userRole === 'admin') {
    header("Location: admindash.php");
    exit();
} elseif ($userRole === 'staff') {
    header("Location: welcomepage.php");
    exit();
} elseif ($userRole === 'student') {
    $departmentPages = [
        'Computer' => 'computer_announcements.php',
        'Electrical' => 'electrical_announcements.php',
        'Civil' => 'civil_announcements.php',
        'Mechanical' => 'mechanical_announcements.php',
    ];
    $redirectPage = $departmentPages[$department] ?? 'defaultpage.php';
    header("Location: $redirectPage");
    exit();
} else {
    header("Location: initialpage.php");
    exit();
}
?>
