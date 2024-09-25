<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Get supplier ID from URL
$supplier_id = $_GET['id'];

// Fetch supplier data
$supplier = getSupplierById($supplier_id);

// Handle form submission for editing the supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_name = $_POST['supplier_name'];
    $contact_info = $_POST['contact_info'];

    if (updateSupplier($supplier_id, $supplier_name, $contact_info)) {
        header('Location: manage_suppliers.php');
        exit();
    } else {
        echo "<p>Error updating supplier. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="css/form.css"> <!-- Link to the correct CSS file -->
</head>
<body>
    <div class="form-container">
        <h1>Edit Supplier</h1>
        <form action="edit_supplier.php?id=<?php echo $supplier_id; ?>" method="post">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" name="supplier_name" id="supplier_name" value="<?php echo htmlspecialchars($supplier['supplier_name']); ?>" required>

            <label for="contact_info">Contact Info</label>
            <input type="text" name="contact_info" id="contact_info" value="<?php echo htmlspecialchars($supplier['contact_info']); ?>" required>

            <button type="submit" class="btn-save">Save Changes</button>
            <a href="manage_suppliers.php" class="btn-back">Back to Manage Suppliers</a>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>