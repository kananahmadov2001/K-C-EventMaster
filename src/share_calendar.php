<?php
require 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str, true);

    // Token Detection 
    $token = htmlentities($json_obj['token']);
    if (!hash_equals($token, $_SESSION['token'])) { // Change logic
        echo('Request forgery detected!!!!');
        die();
    }
    
    $calendar_owner_id = $_SESSION['user_id'];
    $shared_with_user_id = $json_obj['shared_with_user_id'];

    $stmt = $mysqli->prepare("UPDATE events SET shareWith = ? WHERE user_id = ?");
    $stmt->bind_param('ii', $shared_with_user_id, $calendar_owner_id);

    if ($stmt->execute()) {
        echo json_encode(array(
            "success" => true,
            "message" => "Successfully shared calendar."
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Error sharing calendar."
        ));
    }

    $stmt->close();
}
?>