<?php
session_start();

if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit();
}


$username = $_SESSION['username'];

include 'includes/functions.php'; 


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

    <?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <h1>Dashboard</h1>
        <p>Hello, <?php echo htmlspecialchars($username); ?></p>

        <div class="account-btns">
            <a href="my_account.php" class="btn-account">My Account</a>
            <a href="help.php" class="btn-help">Help</a>
        </div>

        <div class="cards">
            <div class="card">
                <img src="images/items.png" alt="Items Icon" width="50"> 
                <h3>Items</h3>
                <p><?php echo $itemCount; ?></p>
            </div>
            <div class="card">
                <img src="images/suppliers.png" alt="Suppliers Icon" width="50">
                <h3>Suppliers</h3>
                <p><?php echo $supplierCount; ?></p>
            </div>
            <div class="card">
                <img src="images/users.png" alt="Users Icon" width="50"> 
                <h3>Users</h3>
                <p><?php echo $userCount; ?></p>
            </div>
            <div class="card">
                <img src="images/returns.png" alt="Return Orders Icon" width="50"> 
                <h3>Return Orders</h3>
                <p><?php echo $returnOrderCount; ?></p>
            </div>
            <div class="card">
                <img src="images/purchase_orders.png" alt="Stock Purchases Icon" width="50">
                <h3>Stock Purchases</h3>
                <p><?php echo $stockPurchaseCount; ?></p>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
