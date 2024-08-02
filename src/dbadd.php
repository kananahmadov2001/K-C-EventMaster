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

    $userID = $_SESSION['user_id'];
    $addTitle = htmlentities((string)$json_obj['title']);
    $addTag = htmlentities((string)$json_obj['tag']);
    $addDate = htmlentities((string)$json_obj['date']);
    $addTime = htmlentities((string)$json_obj['time']);
    
    // Token Detection 
    $token = htmlentities($json_obj['token']);
    if (!hash_equals($token, $_SESSION['token'])) { // Change logic
        echo('Request forgery detected!!!!');
        die();
    }

    // Carryover from module 3 to get relevant values from db
    $stmt = $mysqli->prepare("INSERT INTO events (user_id, title, date, time, tag) VALUES (?, ?, ?, ?, ?)");
      if (!$stmt) {
        echo "Database error: " . $mysqli->error;
        exit;
      }
      
      $stmt->bind_param('issss', $userID, $addTitle, $addDate, $addTime, $addTag);
      $stmt->execute();

      $stmt->close();

    echo json_encode(array(
        "success" => true,
        "message" => "Event successfully sent!"
    ));
    exit;

?>