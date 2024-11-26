<?php
session_start();
include('../config/db.php');

// Fetch events
$events = $conn->query("SELECT events.id, events.name AS event_name, events.description, events.event_date, categories.name AS category_name, sponsors.name AS sponsor_name
FROM events
JOIN categories ON events.category_id = categories.id
JOIN sponsors ON events.sponsor_id = sponsors.id");

$categories = $conn->query("SELECT * FROM categories");
$sponsors = $conn->query("SELECT * FROM sponsors");

// Add or update event
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $sponsor_id = $_POST['sponsor_id'];
    $event_date = $_POST['event_date'];

    if (isset($_POST['event_id']) && $_POST['event_id'] != "") {
        $id = $_POST['event_id'];
        $conn->query("UPDATE events SET name='$name', description='$description', category_id=$category_id, sponsor_id=$sponsor_id, event_date='$event_date' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO events (name, description, category_id, sponsor_id, event_date) VALUES ('$name', '$description', $category_id, $sponsor_id, '$event_date')");
    }
    header("Location: manage_events.php");
}

// Delete event
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM events WHERE id=$id");
    header("Location: manage_events.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link rel="stylesheet" href="events.css"> <!-- External stylesheet link -->
</head>
<body>
    <?php include("navbar.php"); ?>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Events</h1>
        </div>

        <div class="admin-content">
            <h2>Add / Edit Event</h2>
            <form method="post" action="" class="event-form">
                <input type="hidden" name="event_id" id="event_id">
                <label for="name">Event Name:</label>
                <input type="text" name="name" id="name" required placeholder="Enter event name">
                
                <label for="description">Description:</label>
                <textarea name="description" id="description" required placeholder="Enter event description"></textarea>
                
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" required>
                    <?php while ($row = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="sponsor_id">Sponsor:</label>
                <select name="sponsor_id" id="sponsor_id" required>
                    <?php while ($row = $sponsors->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="event_date">Event Date:</label>
                <input type="date" name="event_date" id="event_date" required>

                <button type="submit" class="btn-submit">Save</button>
            </form>

            <h2>Event List</h2>
            <table class="event-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Sponsor</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $events->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['sponsor_name']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td>
                                <a href="manage_events.php?delete_id=<?php echo $row['id']; ?>" class="btn-delete">Delete</a>
                                <a href="#" onclick="editEvent(<?php echo $row['id']; ?>, '<?php echo $row['event_name']; ?>', '<?php echo addslashes($row['description']); ?>', <?php echo $row['category_id']; ?>, <?php echo $row['sponsor_id']; ?>, '<?php echo $row['event_date']; ?>')" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function editEvent(id, name, description, categoryId, sponsorId, eventDate) {
            document.getElementById('event_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('description').value = description;
            document.getElementById('category_id').value = categoryId;
            document.getElementById('sponsor_id').value = sponsorId;
            document.getElementById('event_date').value = eventDate;
        }
    </script>
</body>
</html>
