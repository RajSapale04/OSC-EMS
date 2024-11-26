<?php
session_start();
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch summary data
$categories = $conn->query("SELECT COUNT(*) AS total FROM categories")->fetch_assoc();
$sponsors = $conn->query("SELECT COUNT(*) AS total FROM sponsors")->fetch_assoc();
$events = $conn->query("SELECT COUNT(*) AS total FROM events")->fetch_assoc();
$users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc();
$bookings = $conn->query("SELECT 
    COUNT(*) AS total, 
    SUM(CASE WHEN status='Pending' THEN 1 ELSE 0 END) AS pending,
    SUM(CASE WHEN status='Confirmed' THEN 1 ELSE 0 END) AS confirmed,
    SUM(CASE WHEN status='Cancelled' THEN 1 ELSE 0 END) AS cancelled
FROM bookings")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to external CSS -->
</head>

<body>
    <?php include("navbar.php"); ?>
    
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome to Admin Dashboard</h1>
        </div>

        <div class="dashboard-summary">
            <div class="summary-box">
                <h3>Total Categories</h3>
                <p><?php echo $categories['total']; ?></p>
            </div>

            <div class="summary-box">
                <h3>Total Sponsors</h3>
                <p><?php echo $sponsors['total']; ?></p>
            </div>

            <div class="summary-box">
                <h3>Total Events</h3>
                <p><?php echo $events['total']; ?></p>
            </div>

            <div class="summary-box">
                <h3>Total Users</h3>
                <p><?php echo $users['total']; ?></p>
            </div>

            <div class="summary-box">
                <h3>Total Bookings</h3>
                <p><?php echo $bookings['total']; ?></p>
            </div>

            <div class="summary-box">
                <h3>Pending Bookings</h3>
                <p><?php echo $bookings['pending']; ?></p>
            </div>

            <div class="summary-box">
                <h3>Confirmed Bookings</h3>
                <p><?php echo $bookings['confirmed']; ?></p>
            </div>

            <div class="summary-box">
                <h3>Cancelled Bookings</h3>
                <p><?php echo $bookings['cancelled']; ?></p>
            </div>
        </div>

    </div>
</body>

</html>
