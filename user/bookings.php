<?php
session_start();
include('../config/db.php');

// Fetch user bookings
$user_id = $_SESSION['user_id'];
$bookings = $conn->query("SELECT bookings.*, events.name AS event_name, bookings.status 
    FROM bookings 
    JOIN events ON bookings.event_id = events.id 
    WHERE bookings.user_id=$user_id");

// Handle cancel booking
if (isset($_GET['cancel_booking_id'])) {
    $booking_id = $_GET['cancel_booking_id'];
    $conn->query("UPDATE bookings SET status='Cancelled' WHERE id=$booking_id AND status='Pending'");
    header("Location: bookings.php");
}

// Handle delete booking
if (isset($_GET['delete_booking_id'])) {
    $booking_id = $_GET['delete_booking_id'];
    // Only delete cancelled bookings
    $conn->query("DELETE FROM bookings WHERE id=$booking_id AND status='Cancelled'");
    header("Location: bookings.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="bookings.css"> <!-- Link to external CSS for styling -->
</head>
<body>
    <?php include("navbar.php"); ?>
    
    <div class="container">
        <div class="header">
            <h1>My Bookings</h1>
            <p>Manage your bookings for upcoming events here.</p>
        </div>

        <div class="bookings-table">
            <table>
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['event_name']; ?></td>
                            <td class="<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></td>
                            <td>
                                <?php if ($row['status'] == 'Pending'): ?>
                                    <a href="bookings.php?cancel_booking_id=<?php echo $row['id']; ?>" class="btn-cancel">Cancel</a>
                                <?php elseif ($row['status'] == 'Cancelled'): ?>
                                    <a href="bookings.php?delete_booking_id=<?php echo $row['id']; ?>" class="btn-cancel">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
