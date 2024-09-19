<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    deleteStockPurchase($delete_id);  // Deletes the purchase and adjusts the item quantity
}

// Fetch stock purchases from the database
$purchases = getStockPurchases();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Stock Purchases</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Sidebar with Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1>Manage Stock Purchases</h1>
        <br><br>
        <a href="add_stock_purchase.php"><button class="btn-add">Add New Purchase</button></a>

        <!-- Table for Managing Stock Purchases -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Purchase ID</th>
                        <th>Item Name</th>
                        <th>Supplier Name</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Display purchases dynamically from the database -->
                    <?php foreach ($purchases as $purchase): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($purchase['purchase_id']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['supplier_name']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['purchase_date']); ?></td>
                        <td><?php echo "$" . htmlspecialchars(number_format($purchase['price'], 2)); ?></td>
                        <td>
                            <a href="edit_stock_purchase.php?id=<?php echo $purchase['purchase_id']; ?>"><button class="btn-edit">Edit</button></a>
                            <a href="stock_purchases.php?delete_id=<?php echo $purchase['purchase_id']; ?>"><button class="btn-delete">Delete</button></a>
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
