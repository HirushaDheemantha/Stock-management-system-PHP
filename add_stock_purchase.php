<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission for adding a stock purchase
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $supplier_id = $_POST['supplier_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $purchase_date = $_POST['purchase_date'];

    if (addStockPurchase($item_id, $supplier_id, $quantity, $price, $purchase_date)) {
        header('Location: stock_purchases.php');
        exit();
    } else {
        echo "<p>Error adding stock purchase. Please try again.</p>";
    }
}

// Fetch items and suppliers for the dropdowns
$items = getItems();
$suppliers = getSuppliers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock Purchase</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <div class="form-container">
        <h1>Add Stock Purchase</h1>
        <form action="add_stock_purchase.php" method="post">
            <label for="item_id">Item</label>
            <select name="item_id" required>
                <?php foreach ($items as $item): ?>
                <option value="<?php echo $item['item_id']; ?>"><?php echo htmlspecialchars($item['item_name']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="supplier_id">Supplier</label>
            <select name="supplier_id" required>
                <?php foreach ($suppliers as $supplier): ?>
                <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo htmlspecialchars($supplier['supplier_name']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" required><br><br>

            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" required><br><br>

            <label for="purchase_date">Purchase Date</label>
            <input type="date" name="purchase_date" required><br><br>

            <button type="submit" class="btn-save">Add Purchase</button>
            <a href="stock_purchases.php" class="btn-back">Back to Purchases</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Stock Management System. All rights reserved.</p>
    </footer>
</body>
</html>
