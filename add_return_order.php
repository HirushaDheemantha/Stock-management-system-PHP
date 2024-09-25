<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission to add a new return order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $item_name = $_POST['item_name'];
    $quantity_returned = $_POST['quantity_returned'];
    $status = $_POST['status'];
    $reason = $_POST['reason'];

    if (addReturnOrder($order_id, $item_name, $quantity_returned, $status, $reason)) {
        header('Location: manage_return_orders.php');
        exit();
    } else {
        echo "<p>Error adding return order. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Return Order</title>
    <link rel="stylesheet" href="css/form.css"> <!-- General form styling -->
</head>
<body>
    <div class="form-container">
        <h1>Add Return Order</h1>
        <form action="add_return_order.php" method="post">
            <label>Order ID</label>
            <input type="number" name="order_id" required><br><br>

            <label>Item Name</label>
            <input type="text" name="item_name" required><br><br>

            <label>Quantity Returned</label>
            <input type="number" name="quantity_returned" required><br><br>

            <label>Status</label>
            <select name="status" required>
                <option value="Restocked">Restocked</option>
                <option value="Discarded">Discarded</option>
            </select><br><br>

            <label>Reason</label>
            <textarea name="reason" required></textarea><br><br>

            <button type="submit" class="btn-save">Add Return Order</button>
            <a href="manage_return_orders.php" class="btn-back">Back to Manage Return Orders</a>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
