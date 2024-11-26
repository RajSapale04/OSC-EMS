<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Navbar</title>
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
    <nav class="navbar-admin">
        <ul>
            <li><a href="dashboard.php">Admin Dashboard</a></li>
            <li><a href="manage_categories.php">Manage Categories</a></li>
            <li><a href="manage_sponsors.php">Manage Sponsors</a></li>
            <li><a href="manage_events.php">Manage Events</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_bookings.php">Manage Bookings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
