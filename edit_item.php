<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch item ID from the URL
if (!isset($_GET['id'])) {
    header('Location: manage_items.php');
    exit();
}

$item_id = $_GET['id'];
$item = getItemById($item_id); // Fetch the item data by ID

// Handle form submission for updating the item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if (updateItem($item_id, $item_name, $quantity, $price)) {
        header('Location: manage_items.php');
        exit();
    } else {
        echo "<div class='error-message'>Failed to update the item. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Manage Items</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <div class="form-container">
        <h1>Edit Manage Items</h1>

        <form action="edit_item.php?id=<?php echo $item_id; ?>" method="post" class="edit-form">
            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" id="item_name" value="<?php echo htmlspecialchars($item['Item_name']); ?>" required><br>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" required><br>

            <label for="price">Price</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($item['price']); ?>" required><br>

            <button type="submit" class="btn-save">Save Changes</button>
            <a href="manage_items.php" class="btn-back">Go Back</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Stock Management System. All rights reserved.</p>
    </footer>
</body>
</html>
