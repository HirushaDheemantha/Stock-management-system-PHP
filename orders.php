<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    deleteOrder($delete_id); // This function will delete the order and adjust the item quantity
    header('Location: orders.php');
    exit();
}
// Fetch orders from the database
$orders = getOrders(); // This function will fetch all orders from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Sidebar with Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1>Manage Orders</h1>
        <br><br>
        <a href="add_order.php"><button class="btn-add">Add New Order</button></a>

        <!-- Table for Managing Orders -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Item ID</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['item_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td><span class="status-<?php echo strtolower(htmlspecialchars($order['order_status'])); ?>"><?php echo htmlspecialchars($order['order_status']); ?></span></td>
                        <td>
                            <a href="edit_order.php?id=<?php echo $order['order_id']; ?>"><button class="btn-edit">Edit</button></a>
                            <a href="orders.php?delete_id=<?php echo $order['order_id']; ?>"><button class="btn-delete">Delete</button></a>
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


