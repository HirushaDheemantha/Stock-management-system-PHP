<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit();
}

// Fetch the username from the session
$username = $_SESSION['username'];

include 'includes/functions.php'; // Include the functions file

// Fetch the data counts
$itemCount = getItemCount();
$supplierCount = getSupplierCount();
$userCount = getUserCount();
$returnOrderCount = getReturnOrderCount();
$stockPurchaseCount = getStockPurchaseCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <h1>Dashboard</h1>
        <p>Hello, <?php echo htmlspecialchars($username); ?></p>

        <!-- My Account and Help Button -->
        <div class="account-btns">
            <a href="my_account.php" class="btn-account">My Account</a>
            <a href="#" class="btn-help">Help</a>
        </div>

        <!-- Cards Section -->
        <div class="cards">
            <div class="card">
                <h3>Items</h3>
                <p><?php echo $itemCount; ?></p>
            </div>
            <div class="card">
                <h3>Suppliers</h3>
                <p><?php echo $supplierCount; ?></p>
            </div>
            <div class="card">
                <h3>Users</h3>
                <p><?php echo $userCount; ?></p>
            </div>
            <div class="card">
                <h3>Return Orders</h3>
                <p><?php echo $returnOrderCount; ?></p>
            </div>
            <div class="card">
                <h3>Stock Purchases</h3>
                <p><?php echo $stockPurchaseCount; ?></p>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
