<?php
session_start(); // Start the session
include 'includes/functions.php';

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    deleteUser($delete_id);  // Directly delete the user
}


// Fetch all users
$users = getUsers(); // Fetch users from the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1>Manage Users</h1>
        
        <!-- Button to go to the Admin Dashboard -->
        <a href="admin_page.php"><button class="btn-back">Go to Dashboard</button></a>

        <a href="add_user.php"><button class="btn-add">Add New User</button></a>


        <!-- Table for Managing Users -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <<td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">
                                <button class="btn-edit">Edit</button>
                            </a>
                        </td> 
                            <td><a href="manage_users.php?delete_id=<?php echo $user['id']; ?>">
                                <button class="btn-delete">Delete</button>
                                </td></a>
                            
                            
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
