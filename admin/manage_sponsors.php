<?php
session_start();
include('../config/db.php');

// Fetch sponsors
$sponsors = $conn->query("SELECT * FROM sponsors");

// Add, update, or delete sponsors
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $details = $_POST['details'];
    if (isset($_POST['sponsor_id']) && $_POST['sponsor_id'] != "") {
        $id = $_POST['sponsor_id'];
        $conn->query("UPDATE sponsors SET name='$name', details='$details' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO sponsors (name, details) VALUES ('$name', '$details')");
    }
    header("Location: manage_sponsors.php");
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM sponsors WHERE id=$id");
    header("Location: manage_sponsors.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sponsors</title>
    <link rel="stylesheet" href="sponsors.css"> <!-- External stylesheet link -->
</head>

<body>
    <?php include("navbar.php"); ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Sponsors</h1>
        </div>

        <div class="admin-content">
            <h2>Add / Edit Sponsor</h2>
            <form method="post" action="" class="sponsor-form">
                <input type="hidden" name="sponsor_id" id="sponsor_id">
                <label for="name">Sponsor Name:</label>
                <input type="text" name="name" id="name" required placeholder="Enter sponsor name">
                
                <label for="details">Details:</label>
                <textarea name="details" id="details" required placeholder="Enter sponsor details"></textarea>

                <button type="submit" class="btn-submit">Save</button>
            </form>

            <h2>Sponsor List</h2>
            <table class="sponsor-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $sponsors->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['details']; ?></td>
                            <td>
                                <a href="manage_sponsors.php?delete_id=<?php echo $row['id']; ?>" class="btn-delete">Delete</a>
                                <a href="#" onclick="editSponsor(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo addslashes($row['details']); ?>')" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function editSponsor(id, name, details) {
            document.getElementById('sponsor_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('details').value = details;
        }
    </script>
</body>

</html>
