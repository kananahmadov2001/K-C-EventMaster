<?php
    require "database.php";

    header("Content-Type: application/json");
    ini_set("session.cookie_httponly", 1);
    
    session_start();

    // User Agent Consistency
    $previous_ua = @$_SESSION['useragent'];
    $current_ua = $_SERVER['HTTP_USER_AGENT'];

    if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
        die("Session hijack detected");
    }else{
        $_SESSION['useragent'] = $current_ua;
    }

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str, true);

    // Token Detection 
    $token = htmlentities($json_obj['token']);
    if (!hash_equals($token, $_SESSION['token'])) { // Change logic
        echo('Request forgery detected!!!!');
        die();
    }
    
    // will utilize user_id from session to choose which user not to list in share calendar
    $loggedin_userID = $_SESSION['user_id'];
    $users = array();

    $stmt = $mysqli->prepare("SELECT id, username FROM users");
    
    if (!$stmt) {
        echo json_encode(array('success' => false, 'message' => "Database error: " . $mysqli->error));
        exit;
    }

    $stmt->execute();
    $stmt->bind_result($userID, $username);

    while($stmt->fetch()) {
        $users[] = array(
            "id" => $userID,
            "username" => $username
        );
    }
    
    $stmt->close();
    
    echo json_encode(array(
        "success" => true,
        "users" => $users,
        "loggedin_userID" => $loggedin_userID,
        "message" => "Events retrieved successfully!"
    ));
    
    exit;

?>