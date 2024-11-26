<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$user_id");
    $message = "Profile updated successfully!";
    $user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="profile.css"> <!-- Link to external CSS for styling -->
</head>
<body>
    <?php include("navbar.php"); ?>
    
    <div class="container">
        <div class="header">
            <h1>Update Profile</h1>
            <p>Update your personal information below.</p>
        </div>

        <div class="profile-form">
            <?php if (isset($message)) {
                echo "<p class='success-message'>$message</p>";
            } ?>
            <form method="post" action="">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required>

                <button type="submit">Update</button>
            </form>
        </div>

        <div class="back-link">
            <a href="index.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
