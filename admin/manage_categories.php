<?php
session_start();
include('../config/db.php');

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Add or update category
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    if (isset($_POST['category_id']) && $_POST['category_id'] != "") {
        $id = $_POST['category_id'];
        $conn->query("UPDATE categories SET name='$name' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO categories (name) VALUES ('$name')");
    }
    header("Location: manage_categories.php");
}

// Delete category
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM categories WHERE id=$id");
    header("Location: manage_categories.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="categories.css"> <!-- External stylesheet link -->
</head>
<body>
    <?php include ("navbar.php"); ?>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Categories</h1>
        </div>

        <div class="admin-content">
            <h2>Add / Edit Category</h2>
            <form method="post" action="" class="category-form">
                <input type="hidden" name="category_id" id="category_id">
                <label for="name">Category Name:</label>
                <input type="text" name="name" id="name" required placeholder="Enter category name">
                <button type="submit" class="btn-submit">Save</button>
            </form>

            <h2>Category List</h2>
            <table class="category-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $categories->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <a href="manage_categories.php?delete_id=<?php echo $row['id']; ?>" class="btn-delete">Delete</a>
                                <a href="#" onclick="editCategory(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>')" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function editCategory(id, name) {
            document.getElementById('category_id').value = id;
            document.getElementById('name').value = name;
        }
    </script>
</body>
</html>
