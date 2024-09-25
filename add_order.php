<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch items for the dropdown
$items = getItems();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $order_date = $_POST['order_date'];
    $order_status = $_POST['order_status'];

    if (addOrder($item_id, $quantity, $order_date, $order_status)) {
        header('Location: orders.php');
        exit();
    } else {
        echo "<p>Error adding order. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Order</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <div class="form-container">
        <h1>Add New Order</h1>
        <form action="add_order.php" method="post">
            <label for="item_id">Item</label>
            <select name="item_id" id="item_id" required>
                <?php foreach ($items as $item): ?>
                    <option value="<?php echo $item['item_id']; ?>"><?php echo htmlspecialchars($item['item_name']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" required><br><br>

            <label for="order_date">Order Date</label>
            <input type="date" name="order_date" id="order_date" required><br><br>

            <label for="order_status">Order Status</label>
            <select name="order_status" id="order_status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select><br><br>

            <button type="submit" class="btn-save">Add Order</button>
            <a href="orders.php" class="btn-back">Back to Orders</a>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
