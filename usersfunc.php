
<?php

function deleteUser($id) {
    $conn = connectDB();
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $deleted = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return $deleted;
}


// Function to update a user, with password update only if provided
function updateUser($user_id, $username, $firstname, $lastname, $email, $role, $password = null) {
    $conn = connectDB();

    // Base query to update user details
    $sql = "UPDATE users SET username = ?, firstname = ?, lastname = ?, email = ?, role = ?";
    if ($password) {
        $sql .= ", password = ?"; // Add password if provided
    }
    $sql .= " WHERE id = ?";

    if ($password) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $username, $firstname, $lastname, $email, $role, $password, $user_id);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $firstname, $lastname, $email, $role, $user_id);
    }

    $result = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $result;
}

function getUserById($user_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT id, username, firstname, lastname, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $user;
}

// Function to add a new user to the database
function addUser($username, $firstname, $lastname, $email, $role, $password) {
    $conn = connectDB();

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return false; // Username or email already exists
    }

    // Insert the new user
    $stmt = $conn->prepare("INSERT INTO users (username, firstname, lastname, email, role, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $firstname, $lastname, $email, $role, $password);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}

function getUsers() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT id, username, firstname, lastname, email, role FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $users;
}

?>