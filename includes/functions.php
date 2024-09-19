<?php
// Connect to the database
function connectDB() {
    $conn = new mysqli('localhost', 'root', '', 'inventory_system');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to get the count of items
function getItemCount() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM items");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count;
}

// Function to get the count of suppliers
function getSupplierCount() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM suppliers");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count;
}

// Function to get the count of users
function getUserCount() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count;
}

// Function to get the count of return orders
function getReturnOrderCount() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM return_tables");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count;
}

// Function to get the count of stock purchases
function getStockPurchaseCount() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM stock_purchases");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count;
}





// Register a new user
function registerUser($username, $password, $firstname, $lastname, $email) {
    $conn = connectDB();
    $hashedPassword = md5($password); // Change this to password_hash() in production
    $role = 'user'; // Default role is 'user'

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return false; // Username or email already exists
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password, firstname, lastname, email, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $hashedPassword, $firstname, $lastname, $email, $role);
    return $stmt->execute();
}

// Get user role and validate login credentials
function getUserRole($username, $password) {
    $conn = connectDB();
    $hashedPassword = md5($password); // Change this to match the hash method used
    $stmt = $conn->prepare("SELECT role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $hashedPassword);
    $stmt->execute();
    $stmt->bind_result($role);

    // Debugging: Check if the query returns the correct role
    if ($stmt->fetch()) {
        return $role; // Return the user's role
    } else {
        echo "<div class='alert alert-danger'>Incorrect username or password.</div>";
        return false; // Invalid login credentials
    }
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


// Get user data by username
function getUserData($username) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT username, firstname, lastname, email FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Update user profile data
function updateUserProfile($old_username, $new_username, $email, $firstname, $lastname) {
    $conn = connectDB();

    // Check if new username or email already exists for another user
    $stmt = $conn->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND username != ?");
    $stmt->bind_param("sss", $new_username, $email, $old_username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        return false; // Username or email already exists for another user
    }

    // Update user data
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, firstname = ?, lastname = ? WHERE username = ?");
    $stmt->bind_param("sssss", $new_username, $email, $firstname, $lastname, $old_username);
    return $stmt->execute();
}
//getitems
function getItems() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT item_id, item_name, quantity, price FROM items");
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    
    // Fetch all items and store them in an array
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
    $conn->close();
    
    return $items;
}

// Fetch a single item by its ID
function getItemById($item_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT Item_id, Item_name, quantity, price FROM items WHERE Item_id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $item;
}


// Update an item in the database
function updateItem($item_id, $item_name, $quantity, $price) {
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE items SET item_name = ?, quantity = ?, price = ? WHERE item_id = ?");
    $stmt->bind_param("sidi", $item_name, $quantity, $price, $item_id);

    $updated = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return $updated;
}

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

// Function to add a new item to the database
function addItem($item_name, $quantity, $price) {
    $conn = connectDB();

    // Insert the new item (without specifying item_id, which is auto-incremented)
    $stmt = $conn->prepare("INSERT INTO items (item_name, quantity, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $item_name, $quantity, $price); // 's' for string, 'i' for integer, 'd' for double/float
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}

// Function to delete an item by its item_id
function deleteItem($item_id) {
    $conn = connectDB();

    // Delete the item where the item_id matches
    $stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?");
    $stmt->bind_param("i", $item_id);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}

function getSuppliers() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT supplier_id, supplier_name, contact_info FROM suppliers");
    $stmt->execute();
    $result = $stmt->get_result();
    $suppliers = [];
    
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }

    $stmt->close();
    $conn->close();
    
    return $suppliers;
}

// Function to fetch a single supplier by its ID
function getSupplierById($supplier_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT supplier_id, supplier_name, contact_info FROM suppliers WHERE supplier_id = ?");
    $stmt->bind_param("i", $supplier_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $supplier = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $supplier;
}

// Function to add a new supplier to the database
function addSupplier($supplier_name, $contact_info) {
    $conn = connectDB();

    $stmt = $conn->prepare("INSERT INTO suppliers (supplier_name, contact_info) VALUES (?, ?)");
    $stmt->bind_param("ss", $supplier_name, $contact_info);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}


// Function to update an existing supplier in the database
function updateSupplier($supplier_id, $supplier_name, $contact_info) {
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE suppliers SET supplier_name = ?, contact_info = ? WHERE supplier_id = ?");
    $stmt->bind_param("ssi", $supplier_name, $contact_info, $supplier_id);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}

// Function to delete a supplier by its supplier_id
function deleteSupplier($supplier_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("DELETE FROM suppliers WHERE supplier_id = ?");
    $stmt->bind_param("i", $supplier_id);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}

// Function to fetch a single stock purchase by its ID
function getStockPurchaseById($purchase_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("
        SELECT sp.purchase_id, sp.item_id, sp.supplier_id, sp.quantity, sp.price, sp.purchase_date
        FROM stock_purchases sp
        WHERE sp.purchase_id = ?
    ");
    $stmt->bind_param("i", $purchase_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $purchase = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $purchase;
}


// Function to fetch all stock purchases from the database
function getStockPurchases() {
    $conn = connectDB();
    $stmt = $conn->prepare("
        SELECT sp.purchase_id, i.item_name, s.supplier_name, sp.quantity, sp.purchase_date, sp.price
        FROM stock_purchases sp
        JOIN items i ON sp.item_id = i.item_id
        JOIN suppliers s ON sp.supplier_id = s.supplier_id
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $purchases = [];
    
    while ($row = $result->fetch_assoc()) {
        $purchases[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $purchases;
}

// Function to add a new stock purchase and update item quantity
function addStockPurchase($item_id, $supplier_id, $quantity, $price, $purchase_date) {
    $conn = connectDB();

    // Insert into stock_purchases
    $stmt = $conn->prepare("INSERT INTO stock_purchases (item_id, supplier_id, quantity, price, purchase_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiids", $item_id, $supplier_id, $quantity, $price, $purchase_date);
    $result = $stmt->execute();

    if ($result) {
        // Update the item stock quantity in the items table
        $updateStmt = $conn->prepare("UPDATE items SET quantity = quantity + ? WHERE item_id = ?");
        $updateStmt->bind_param("ii", $quantity, $item_id);
        $updateStmt->execute();
        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();

    return $result;
}

// Function to edit a stock purchase and adjust item quantity
function editStockPurchase($purchase_id, $item_id, $supplier_id, $new_quantity, $price, $purchase_date) {
    $conn = connectDB();

    // Fetch the old quantity for the stock purchase
    $oldStmt = $conn->prepare("SELECT quantity FROM stock_purchases WHERE purchase_id = ?");
    $oldStmt->bind_param("i", $purchase_id);
    $oldStmt->execute();
    $oldStmt->bind_result($old_quantity);
    $oldStmt->fetch();
    $oldStmt->close();

    // Update stock purchase record
    $stmt = $conn->prepare("UPDATE stock_purchases SET item_id = ?, supplier_id = ?, quantity = ?, price = ?, purchase_date = ? WHERE purchase_id = ?");
    $stmt->bind_param("iiidsi", $item_id, $supplier_id, $new_quantity, $price, $purchase_date, $purchase_id);
    $result = $stmt->execute();

    if ($result) {
        // Adjust item stock in the items table based on the difference
        $quantity_diff = $new_quantity - $old_quantity;
        $updateStmt = $conn->prepare("UPDATE items SET quantity = quantity + ? WHERE item_id = ?");
        $updateStmt->bind_param("ii", $quantity_diff, $item_id);
        $updateStmt->execute();
        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();

    return $result;
}

function deleteStockPurchase($purchase_id) {
    $conn = connectDB();

    // Fetch the quantity and item_id for the stock purchase
    $stmt = $conn->prepare("SELECT quantity, item_id FROM stock_purchases WHERE purchase_id = ?");
    $stmt->bind_param("i", $purchase_id);
    $stmt->execute();
    $stmt->bind_result($quantity, $item_id);
    $stmt->fetch();
    $stmt->close();

    // Delete the stock purchase
    $stmt = $conn->prepare("DELETE FROM stock_purchases WHERE purchase_id = ?");
    $stmt->bind_param("i", $purchase_id);
    $result = $stmt->execute();

    if ($result) {
        // Reduce the stock in the items table
        $updateStmt = $conn->prepare("UPDATE items SET quantity = quantity - ? WHERE item_id = ?");
        $updateStmt->bind_param("ii", $quantity, $item_id);
        $updateStmt->execute();
        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();

    return $result;
}

// Function to fetch a single order by its ID
function getOrderById($order_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT order_id, item_id, quantity, order_date, order_status FROM `order` WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $order;
}


// Function to fetch all orders
function getOrders() {
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT order_id, item_id, quantity, order_date, order_status FROM `order`");
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $orders;
}

// Function to add a new order
function addOrder($item_id, $quantity, $order_date, $order_status) {
    $conn = connectDB();

    // Insert into orders table
    $stmt = $conn->prepare("INSERT INTO `order` (item_id, quantity, order_date, order_status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $item_id, $quantity, $order_date, $order_status);
    $result = $stmt->execute();

    if ($result) {
        // Reduce the item quantity in the items table
        $updateStmt = $conn->prepare("UPDATE items SET quantity = quantity - ? WHERE item_id = ?");
        $updateStmt->bind_param("ii", $quantity, $item_id);
        $updateStmt->execute();
        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();

    return $result;
}

// Function to edit an order
function editOrder($order_id, $item_id, $new_quantity, $order_date, $order_status) {
    $conn = connectDB();

    // Fetch the old quantity for the order
    $oldStmt = $conn->prepare("SELECT quantity FROM `order` WHERE order_id = ?");
    $oldStmt->bind_param("i", $order_id);
    $oldStmt->execute();
    $oldStmt->bind_result($old_quantity);
    $oldStmt->fetch();
    $oldStmt->close();

    // Update order record
    $stmt = $conn->prepare("UPDATE `order` SET item_id = ?, quantity = ?, order_date = ?, order_status = ? WHERE order_id = ?");
    $stmt->bind_param("iissi", $item_id, $new_quantity, $order_date, $order_status, $order_id);
    $result = $stmt->execute();

    if ($result) {
        // Adjust item stock in the items table based on the difference
        $quantity_diff = $old_quantity - $new_quantity;
        $updateStmt = $conn->prepare("UPDATE items SET quantity = quantity + ? WHERE item_id = ?");
        $updateStmt->bind_param("ii", $quantity_diff, $item_id);
        $updateStmt->execute();
        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();

    return $result;
}

// Function to delete an order and adjust item quantity
function deleteOrder($order_id) {
    $conn = connectDB();

    // Fetch the quantity and item_id for the order
    $selectStmt = $conn->prepare("SELECT quantity, item_id FROM `order` WHERE order_id = ?");
    $selectStmt->bind_param("i", $order_id);
    $selectStmt->execute();
    $selectStmt->bind_result($quantity, $item_id);
    $selectStmt->fetch();
    $selectStmt->close();

    // Delete the order
    $stmt = $conn->prepare("DELETE FROM `order` WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $result = $stmt->execute();

    if ($result) {
        // Increase the stock in the items table
        $updateStmt = $conn->prepare("UPDATE items SET quantity = quantity + ? WHERE item_id = ?");
        $updateStmt->bind_param("ii", $quantity, $item_id);
        $updateStmt->execute();
        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();

    return $result;
}


function getReturnOrders() {
    $conn = connectDB();
    $stmt = $conn->prepare("
        SELECT return_id, order_id, item_name, quantity_returned, status, reason 
        FROM return_tables
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $return_orders = [];
    
    while ($row = $result->fetch_assoc()) {
        $return_orders[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $return_orders;
}
function getReturnOrderById($return_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("
        SELECT return_id, order_id, item_name, quantity_returned, status, reason 
        FROM return_tables 
        WHERE return_id = ?
    ");
    $stmt->bind_param("i", $return_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $return_order = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $return_order;
}
function addReturnOrder($order_id, $item_name, $quantity_returned, $status, $reason) {
    $conn = connectDB();
    $stmt = $conn->prepare("
        INSERT INTO return_tables (order_id, item_name, quantity_returned, status, reason) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isiss", $order_id, $item_name, $quantity_returned, $status, $reason);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}
function updateReturnOrder($return_id, $order_id, $item_name, $quantity_returned, $status, $reason) {
    $conn = connectDB();
    $stmt = $conn->prepare("
        UPDATE return_tables 
        SET order_id = ?, item_name = ?, quantity_returned = ?, status = ?, reason = ? 
        WHERE return_id = ?
    ");
    $stmt->bind_param("isissi", $order_id, $item_name, $quantity_returned, $status, $reason, $return_id);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}
function deleteReturnOrder($return_id) {
    $conn = connectDB();
    $stmt = $conn->prepare("DELETE FROM return_tables WHERE return_id = ?");
    $stmt->bind_param("i", $return_id);
    $result = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $result;
}

?>




