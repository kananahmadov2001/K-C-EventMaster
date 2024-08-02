<?php
require 'database.php';

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

// Retrieve and decode the JSON input
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$username = htmlentities((string)$json_obj['username']);
$password = htmlentities((string)$json_obj['password']);

// Check if the username already exists
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
if (!$stmt) {
    echo json_encode(array(
        "success" => false,
        "message" => "Database error: " . $mysqli->error
    ));
    exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Username already exists
    echo json_encode(array(
        "success" => false,
        "message" => "Username already exists"
    ));
    exit;
}

$stmt->close();

// Hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insert the new user into the database
$stmt = $mysqli->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
if (!$stmt) {
    echo json_encode(array(
        "success" => false,
        "message" => "Database error: " . $mysqli->error
    ));
    exit;
}

$stmt->bind_param('ss', $username, $password_hash);

if ($stmt->execute()) {
    echo json_encode(array(
        "success" => true,
        "message" => "User registered successfully"
    ));
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Registration failed"
    ));
}

    $stmt->close();
?>