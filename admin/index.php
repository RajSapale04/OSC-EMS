<?php
session_start();
include('config/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as admin
$is_admin = isset($_SESSION['admin_id']);
if (!$is_admin) {
    // Redirect to login page if not logged in as admin
    header("Location:login.php");
    exit();
}else{
    header("Location:dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('navbar.php'); ?>
</body>
</html>
