<?php

require "database.php";
header("Content-Type: application/json"); 
ini_set("session.cookie_httponly", 1);
session_start();

// Ensure the request method is POST
// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     echo json_encode(array(
//         "success" => false,
//         "message" => "Invalid request method."
//     ));
//     exit;
// }

// Get the event ID from the request
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

if (!isset($json_obj['eventID'])) {
    echo json_encode(array(
        "success" => false,
        "message" => "Event ID is required."
    ));
    exit;
}

$eventID = (int)$json_obj['eventID'];
$userID = $_SESSION['user_id']; // Assuming 'user_id' is stored in the session

// Token Detection 
$token = htmlentities($json_obj['token']);
if (!hash_equals($token, $_SESSION['token'])) { // Change logic
    echo('Request forgery detected!!!!');
    die();
}

// Prepare and execute the SQL statement
$stmt = $mysqli->prepare("DELETE FROM events WHERE id=? AND user_id=?");
if (!$stmt) {
    echo json_encode(array(
        "success" => false,
        "message" => "Query preparation failed: " . htmlspecialchars($mysqli->error)
    ));
    exit;
}

$stmt->bind_param('ii', $eventID, $userID);

if ($stmt->execute()) {
    echo json_encode(array(
        "success" => true,
        "message" => "Event deleted successfully."
    ));
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Event deletion failed: " . htmlspecialchars($stmt->error)
    ));
}

$stmt->close();

?>