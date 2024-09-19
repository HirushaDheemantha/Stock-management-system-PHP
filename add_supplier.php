<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission for adding a new supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_name = $_POST['supplier_name'];
    $contact_info = $_POST['contact_info'];

    if (addSupplier($supplier_name, $contact_info)) {
        header('Location: manage_suppliers.php');
        exit();
    } else {
        echo "<p>Error adding supplier. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link rel="stylesheet" href="css/form.css"> <!-- General form styling -->
</head>
<body>
    <div class="form-container">
        <h1>Add New Supplier</h1>
        <form action="add_supplier.php" method="post">
            <label>Supplier Name</label>
            <input type="text" name="supplier_name" required><br><br>

            <label>Contact Info</label>
            <input type="text" name="contact_info" required><br><br>

            <button type="submit" class="btn-save">Add Supplier</button>
            <a href="manage_suppliers.php" class="btn-back">Back to Manage Suppliers</a>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Stock Management System. All rights reserved.</p>
    </footer>
</body>
</html>
