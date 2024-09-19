<?php
session_start();
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle login
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check user role
        $role = getUserRole($username, $password);
        
        if ($role) {
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $username;

            // Redirect based on the user role
            if ($role == 'user') {
                header('Location: index.php');
                exit();
            } elseif ($role == 'admin') {
                header('Location: admin_page.php');
                exit();
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid login credentials.</div>";
        }
    }
}

// Handle registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    if (registerUser($username, $password, $firstname, $lastname, $email)) {
        echo "<div class='alert alert-success'>Registration successful! Redirecting to login...</div>";
        header("refresh:2;url=login.php"); // Redirect to login after 2 seconds
        exit();
    } else {
        echo "<div class='alert alert-danger'>Registration failed. Username or email already exists.</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Login Form -->
            <form id="loginForm" action="login.php" method="POST">
                <h2>Login</h2>
                <label for="login-username">Username</label>
                <input type="text" id="login-username" name="username" placeholder="Enter your username" required>
                
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showSignUp()">Sign up here</a></p>
            </form>

            <!-- Registration Form -->
            <form id="signupForm" action="login.php" method="POST" style="display:none;">
                <h2>Sign Up</h2>
                <label for="signup-username">Username</label>
                <input type="text" id="signup-username" name="username" placeholder="Enter a username" required>
                
                <label for="signup-firstname">First Name</label>
                <input type="text" id="signup-firstname" name="firstname" placeholder="Enter your first name" required>

                <label for="signup-lastname">Last Name</label>
                <input type="text" id="signup-lastname" name="lastname" placeholder="Enter your last name" required>

                <label for="signup-email">Email</label>
                <input type="email" id="signup-email" name="email" placeholder="Enter your email" required>
                
                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Enter a password" required>
                
                <label for="signup-confirm-password">Confirm Password</label>
                <input type="password" id="signup-confirm-password" name="confirm_password" placeholder="Confirm your password" required>
                
                <button type="submit" name="register">Sign Up</button>
                <p>Already have an account? <a href="#" onclick="showLogin()">Login here</a></p>
            </form>
        </div>
    </div>

    <script>
        function showSignUp() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('signupForm').style.display = 'block';
        }

        function showLogin() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('signupForm').style.display = 'none';
        }
    </script>
</body>
</html>
