<?php
session_start();
include('../config/db.php');

// Fetch users
$users = $conn->query("SELECT * FROM users");

// Handle block/unblock user
if (isset($_GET['toggle_block_id'])) {
    $id = $_GET['toggle_block_id'];
    $current_status = $_GET['current_status'];
    $new_status = $current_status == 1 ? 0 : 1; // Toggle block status
    $conn->query("UPDATE users SET is_blocked=$new_status WHERE id=$id");
    header("Location: manage_users.php");
}

// Update user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    header("Location: manage_users.php");
}

if (isset($_GET['edit_id'])) {
    // Fetch the specific user data for editing
    $edit_id = $_GET['edit_id'];
    $edit_user = $conn->query("SELECT * FROM users WHERE id=$edit_id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="users.css">

</head>

<body>
    <?php include("navbar.php"); ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Users</h1>
        </div>

        <div class="admin-content">
            <h2>Users List</h2>
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['is_blocked'] ? 'Blocked' : 'Active'; ?></td>
                            <td>
                                <a href="manage_users.php?toggle_block_id=<?php echo $row['id']; ?>&current_status=<?php echo $row['is_blocked']; ?>"
                                    class="btn-toggle"><?php echo $row['is_blocked'] ? 'Unblock' : 'Block'; ?></a>
                                <a href="manage_users.php?edit_id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if (isset($edit_user)): ?>
                <h2>Edit User</h2>
                <form method="post" action="" class="user-form">
                    <input type="hidden" name="user_id" value="<?php echo $edit_user['id']; ?>">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo $edit_user['name']; ?>" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $edit_user['email']; ?>" required>
                    
                    <button type="submit" class="btn-submit">Save</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
