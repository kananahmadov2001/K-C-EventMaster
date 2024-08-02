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

    // Token Detection (W.I.P)
    if (!isset($_SESSION['token'])) { // Change logic
        echo('Request forgery detected!!!!');
        die();
    }

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str, true);

    $userID = $_SESSION['user_id'];

    $editTitle = htmlentities((string)$json_obj['title']);
    $editTag = htmlentities((string)$json_obj['tag']);
    $editDate = htmlentities((string)$json_obj['date']);
    $editTime = htmlentities((string)$json_obj['time']);
    $eventID = htmlentities((int)$json_obj['eventID']);

    // Token Detection 
    $token = htmlentities($json_obj['token']);
    if (!hash_equals($token, $_SESSION['token'])) { // Change logic
        echo('Request forgery detected!!!!');
        die();
    }

    // Carryover from module 3 to get relevant values from db
    $stmt = $mysqli->prepare("UPDATE events SET title = ?, tag = ?, date = ?, time = ? WHERE id = ? AND user_id = ?");
      if (!$stmt) {
        echo "Database error: " . $mysqli->error;
        exit;
      }
      
    $stmt->bind_param('ssssii', $editTitle, $editTag, $editDate, $editTime, $eventID, $userID);
    $stmt->execute();

    $stmt->close();

    echo json_encode(array(
        "success" => true,
        "message" => "Event successfully edited!"
    ));
    exit;

?>