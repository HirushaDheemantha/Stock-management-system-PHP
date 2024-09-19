<?php
session_start(); // Start the session

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    // If not logged in as admin, redirect to the login page
    header('Location: login.php');
    exit();
}

// Fetch the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


    <!-- Admin Page Content -->
    <div class="main-content">
        <h1>Admin Page</h1>

        <!-- Cards for Admin Functions -->
        <div class="admin-cards">
            <div class="admin-card">
                <h3>Manage Users</h3>
                <p>Control and manage user roles, add new users, and update permissions.</p>
                <a href="manage_users.php" class="btn-action">Go to Manage Users</a> <!-- Link to manage_users.php -->
            </div>
            <div class="admin-card">
                <h3>Dashboard</h3>
                <p>View system statistics, stock levels, and recent activities on the dashboard.</p>
                <a href="index.php" class="btn-action">Go to Dashboard</a> <!-- Link to index.php -->
            </div>
        </div>
        
    </div>
    <section><a href="logout.php" class="btn-action">Logout</a></section>
    <footer>
        <p>&copy; 2024 Stock Management System. All rights reserved.</p>
    </footer>

</body>
</html>
