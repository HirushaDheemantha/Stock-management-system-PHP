<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Check if delete_id is set in the URL, and call the delete function
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Call the delete function and check if successful
    if (deleteItem($delete_id)) {
        header('Location: manage_items.php'); // Redirect to refresh the page after deletion
        exit();
    } else {
        echo "<p>Error deleting the item. Please try again.</p>";
    }
}

// Fetch items from the database
$items = getItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <h1>Manage Items</h1>
        <br>
        <br>

        <!-- Allow all users (including regular users) to add items -->
        <a href="add_item.php"><button class="btn-add">Add New Item</button></a>

        <!-- Table for Managing Items -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo "$" . htmlspecialchars(number_format($item['price'], 2)); ?></td>
                        <td>
                            <a href="edit_item.php?id=<?php echo $item['item_id']; ?>"><button class="btn-edit">Edit</button></a>
                            <!-- No confirmation message for delete -->
                            <a href="manage_items.php?delete_id=<?php echo $item['item_id']; ?>">
                                <button class="btn-delete">Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

