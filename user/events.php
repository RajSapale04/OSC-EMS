<?php
session_start();
include('../config/db.php');

// Fetch events
$events = $conn->query("SELECT events.*, categories.name AS category_name, sponsors.name AS sponsor_name 
    FROM events 
    JOIN categories ON events.category_id = categories.id 
    JOIN sponsors ON events.sponsor_id = sponsors.id");

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch existing bookings if user is logged in
if ($user_id) {
    $bookings = [];
    $booking_query = $conn->query("SELECT event_id FROM bookings WHERE user_id = $user_id");
    while ($row = $booking_query->fetch_assoc()) {
        $bookings[] = $row['event_id'];
    }
}

// Handle booking event
if (isset($_GET['book_event_id'])) {
    $event_id = $_GET['book_event_id'];
    if (!in_array($event_id, $bookings)) {  // Check if the user already registered
        $conn->query("INSERT INTO bookings (user_id, event_id) VALUES ($user_id, $event_id)");
    }
    header("Location: bookings.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Events</title>
    <link rel="stylesheet" href="events.css"> <!-- Link to external CSS for styling -->
</head>
<body>
    <?php include("navbar.php"); ?>

    <div class="container">
        <div class="header">
            <h1>Upcoming Events</h1>
            <p>Explore various events and book your spot now!</p>
        </div>

        <div class="events-table">
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Committee</th>
                        <th>Sponsor</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $events->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['sponsor_name']; ?></td>
                            <td><?php echo date('F j, Y', strtotime($row['event_date'])); ?></td>
                            <td>
                                <?php if (in_array($row['id'], $bookings)): ?>
                                    <span class="registered">Already Registered</span>
                                <?php else: ?>
                                    <a href="events.php?book_event_id=<?php echo $row['id']; ?>" class="btn">Book Now</a>
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
