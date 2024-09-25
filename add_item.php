<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission for adding a new item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Call the function to add the new item
    if (addItem($item_name, $quantity, $price)) {
        echo "<p>Item added successfully!</p>";
        header('Location: manage_items.php');
        exit();
    } else {
        echo "<p>Error adding item. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
    <link rel="stylesheet" href="css/form.css"> <!-- General form styling -->
</head>
<body>
    <div class="form-container">
        <h1>Add New Item</h1>
        <form action="add_item.php" method="post">
            <label>Item Name</label>
            <input type="text" name="item_name" required><br><br>

            <label>Quantity</label>
            <input type="number" name="quantity" required><br><br>

            <label>Price</label>
            <input type="text" name="price" required><br><br>

            <button type="submit" class="btn-save">Add Item</button>
            <a href="manage_items.php" class="btn-back">Back to Manage Items</a>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
