<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('config/db.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title>EMS - Dashboard</title>
    <link rel="stylesheet" href="index.css">

</head>

<body>
    <!-- Guest View -->
    <h1>Welcome to the Event Management System!</h1>
    <p><a href="user/login.php">Login</a> or <a href="user/register.php">Register</a> to get started.</p>
</body>

</html>