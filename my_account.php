<?php
session_start(); // Start the session
include 'includes/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Fetch the username from the session
$username = $_SESSION['username'];

// Fetch user data from the database
$userData = getUserData($username);

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    
    if (updateUserProfile($username, $new_username, $email, $firstname, $lastname)) {
        // Update the session username if changed
        $_SESSION['username'] = $new_username;
        echo "<div class='success-message'>Profile updated successfully!</div>";
    } else {
        echo "<div class='error-message'>Failed to update profile. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="css/account.css"> <!-- Reference to the CSS file -->
</head>
<body>

    <div class="account-container">
        <h1>My Account</h1>

        <form method="POST" action="my_account.php" class="account-form">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>

            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($userData['firstname']); ?>" required>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($userData['lastname']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

            <button type="submit" class="btn-save">Save Changes</button>
            <a href="index.php" class="btn-back">Go to Dashboard</a>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
