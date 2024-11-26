<?php
session_start();
include('../config/db.php');

// Fetch bookings excluding cancelled ones
$bookings = $conn->query("SELECT bookings.id, users.name AS user_name, events.name AS event_name, bookings.status 
    FROM bookings 
    JOIN users ON bookings.user_id = users.id 
    JOIN events ON bookings.event_id = events.id
    WHERE bookings.status != 'Cancelled'"); // Exclude cancelled bookings

// Update booking status
if (isset($_GET['update_status_id'])) {
    $id = $_GET['update_status_id'];
    $new_status = $_GET['status'];
    $conn->query("UPDATE bookings SET status='$new_status' WHERE id=$id");
    header("Location: manage_bookings.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="bookings.css"> <!-- Link to external CSS -->
</head>

<body>
    <?php include("navbar.php"); ?>
    
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Bookings</h1>
        </div>
        
        <div class="admin-content">
            <h2>Bookings List</h2>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="manage_bookings.php?update_status_id=<?php echo $row['id']; ?>&status=Confirmed" class="btn-confirm">Confirm</a>
                                <a href="manage_bookings.php?update_status_id=<?php echo $row['id']; ?>&status=Cancelled" class="btn-cancel">Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
