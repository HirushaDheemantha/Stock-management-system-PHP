<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Get return order ID from URL
$return_id = $_GET['id'];

// Fetch return order data
$return_order = getReturnOrderById($return_id);

// Handle form submission to edit the return order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $item_name = $_POST['item_name'];
    $quantity_returned = $_POST['quantity_returned'];
    $status = $_POST['status'];
    $reason = $_POST['reason'];

    if (updateReturnOrder($return_id, $order_id, $item_name, $quantity_returned, $status, $reason)) {
        header('Location: manage_return_orders.php');
        exit();
    } else {
        echo "<p>Error updating return order. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Return Order</title>
    <link rel="stylesheet" href="css/form.css"> <!-- General form styling -->
</head>
<body>
    <div class="form-container">
        <h1>Edit Return Order</h1>
        <form action="edit_return_order.php?id=<?php echo $return_id; ?>" method="post">
            <label>Order ID</label>
            <input type="number" name="order_id" value="<?php echo htmlspecialchars($return_order['order_id']); ?>" required><br><br>

            <label>Item Name</label>
            <input type="text" name="item_name" value="<?php echo htmlspecialchars($return_order['item_name']); ?>" required><br><br>

            <label>Quantity Returned</label>
            <input type="number" name="quantity_returned" value="<?php echo htmlspecialchars($return_order['quantity_returned']); ?>" required><br><br>

            <label>Status</label>
            <select name="status" required>
                <option value="Restocked" <?php if ($return_order['status'] == 'Restocked') echo 'selected'; ?>>Restocked</option>
                <option value="Discarded" <?php if ($return_order['status'] == 'Discarded') echo 'selected'; ?>>Discarded</option>
            </select><br><br>

            <label>Reason</label>
            <textarea name="reason" required><?php echo htmlspecialchars($return_order['reason']); ?></textarea><br><br>

            <button type="submit" class="btn-save">Save Changes</button>
            <a href="manage_return_orders.php" class="btn-back">Back to Manage Return Orders</a>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
