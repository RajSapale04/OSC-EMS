<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="index.css"> <!-- Link to the external CSS file for styling -->
</head>

<body>
    <?php include("navbar.php"); ?>

    <div class="container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo $user['name']; ?>!</h1>
            <p>Your personalized event management dashboard.</p>
        </div>

        <div class="dashboard-content">
            <div class="section">
                <h2>Upcoming Events</h2>
                <p>Stay updated with the latest events happening around the college.</p>
                <a href="events.php" class="btn">View Events</a>
            </div>
            
            <div class="section">
                <h2>Your Bookings</h2>
                <p>Check your bookings and manage them efficiently.</p>
                <a href="bookings.php" class="btn">My Bookings</a>
            </div>
            
            <div class="section section-third">
                <h2>Account Settings</h2>
                <p>Update your profile</p>
                <a href="profile.php" class="btn">Update Profile</a>
            </div>
        </div>
    </div>
</body>

</html>
