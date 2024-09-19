<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Get order ID from URL
$order_id = $_GET['id'];

// Fetch order data and items
$order = getOrderById($order_id); // You need to create this function similar to `getItemById`
$items = getItems();

// Handle form submission for editing the order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $order_date = $_POST['order_date'];
    $order_status = $_POST['order_status'];

    if (editOrder($order_id, $item_id, $quantity, $order_date, $order_status)) {
        header('Location: orders.php');
        exit();
    } else {
        echo "<p>Error updating order. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <div class="form-container">
        <h1>Edit Order</h1>
        <form action="edit_order.php?id=<?php echo $order_id; ?>" method="post">
            <label for="item_id">Item</label>
            <select name="item_id" id="item_id" required>
                <?php foreach ($items as $item): ?>
                    <option value="<?php echo $item['item_id']; ?>" <?php if ($item['item_id'] == $order['item_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($item['item_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($order['quantity']); ?>" required><br><br>

            <label for="order_date">Order Date</label>
            <input type="date" name="order_date" id="order_date" value="<?php echo htmlspecialchars($order['order_date']); ?>" required><br><br>

            <label for="order_status">Order Status</label>
            <select name="order_status" id="order_status" required>
                <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="In Progress" <?php if ($order['order_status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Completed" <?php if ($order['order_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
            </select><br><br>

            <button type="submit" class="btn-save">Save Changes</button>
            <a href="orders.php" class="btn-back">Back to Orders</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Stock Management System. All rights reserved.</p>
    </footer>
</body>
</html>
