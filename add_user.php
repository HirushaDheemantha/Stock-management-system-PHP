<?php
session_start();
include 'includes/functions.php';

// Check if the admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Handle form submission for adding a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Call the function to add a new user
    if (addUser($username, $firstname, $lastname, $email, $role, $password)) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "<p>Error adding user. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="css/form.css"> <!-- General form styling -->
</head>
<body>
    <div class="form-container">
        <h1>Add New User</h1>
        <form action="add_user.php" method="post">
            <label>Username</label>
            <input type="text" name="username" required><br><br>

            <label>First Name</label>
            <input type="text" name="firstname" required><br><br>

            <label>Last Name</label>
            <input type="text" name="lastname" required><br><br>

            <label>Email</label>
            <input type="email" name="email" required><br><br>

            <label>Role</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select><br><br>

            <label>Password</label>
            <input type="password" name="password" required><br><br>

            <button type="submit" class="btn-save">Add User</button>
            <a href="manage_users.php" class="btn-back">Back to Manage Users</a>
        </form>
    </div>
</body>
</html>
