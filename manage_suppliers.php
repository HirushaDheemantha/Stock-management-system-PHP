<?php
session_start();
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Check if delete_id is set in the URL, and call the delete function
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Call the delete function and check if successful
    if (deleteSupplier($delete_id)) {
        header('Location: manage_suppliers.php'); // Redirect to refresh the page after deletion
        exit();
    } else {
        echo "<p>Error deleting the supplier. Please try again.</p>";
    }
}

// Fetch suppliers from the database
$suppliers = getSuppliers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

    <div class="main-content">
        <h1>Manage Suppliers</h1>
        <br>
        <br>

        <!-- Button to Add New Supplier -->
        <a href="add_supplier.php"><button class="btn-add">Add New Supplier</button></a>

        <!-- Table for Managing Suppliers -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Contact Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Display suppliers dynamically from the database -->
                    <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($supplier['supplier_id']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['supplier_name']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['contact_info']); ?></td>
                        <td>
                            <a href="edit_supplier.php?id=<?php echo $supplier['supplier_id']; ?>"><button class="btn-edit">Edit</button></a>
                            <a href="manage_suppliers.php?delete_id=<?php echo $supplier['supplier_id']; ?>">
                                <button class="btn-delete">Delete</button>
                            </a>
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
