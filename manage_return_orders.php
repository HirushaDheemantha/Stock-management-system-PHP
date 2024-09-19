<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    deleteReturnOrder($delete_id);
    header('Location: manage_return_orders.php');
    exit();
}

// Fetch return orders from the database
$return_orders = getReturnOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Return Orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <h1>Manage Return Orders</h1>
        <br><br>
        <a href="add_return_order.php"><button class="btn-add">Add New Return Order</button></a>

        <!-- Table for Managing Return Orders -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Return ID</th>
                        <th>Order ID</th>
                        <th>Item Name</th>
                        <th>Quantity Returned</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($return_orders as $return_order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($return_order['return_id']); ?></td>
                        <td><?php echo htmlspecialchars($return_order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($return_order['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($return_order['quantity_returned']); ?></td>
                        <td><?php echo htmlspecialchars($return_order['status']); ?></td>
                        <td><?php echo htmlspecialchars($return_order['reason']); ?></td>
                        <td>
                            <a href="edit_return_order.php?id=<?php echo $return_order['return_id']; ?>"><button class="btn-edit">Edit</button></a>
                            <a href="manage_return_orders.php?delete_id=<?php echo $return_order['return_id']; ?>"><button class="btn-delete">Delete</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Stock Management System. All rights reserved.</p>
    </footer>
</body>
</html>
