<?php
session_start();
include 'includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$user_id = $_GET['id'];
$user = getUserById($user_id); // Fetch the user data by ID

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Update the user data (and password if provided)
    if (updateUser($user_id, $username, $firstname, $lastname, $email, $role, $password)) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "<p>Error updating user. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/form.css"> 
</head>
<body>
    <div class="form-container">
        <h1>Edit User</h1>
        <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

            <label>First Name</label>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required><br><br>

            <label>Last Name</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required><br><br>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

            <label>Role</label>
            <select name="role" required>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
            </select><br><br>

            <label>Password (Optional)</label>
            <input type="password" name="password" placeholder="Enter new password"><br><br>

            <button type="submit" class="btn-save">Save Changes</button>
            <a href="manage_users.php" class="btn-back">Back</a>
        </form>
    </div>
</body>
</html>
