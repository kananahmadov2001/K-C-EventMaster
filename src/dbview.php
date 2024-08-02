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
    $events = array();

    $queryType = htmlentities((string)$json_obj['type']);
    
    // Token Detection 
    $token = htmlentities($json_obj['token']);
    if (!hash_equals($token, $_SESSION['token'])) { // Change logic
        echo('Request forgery detected!!!!');
        die();
    }

    if ($queryType == "byDate"){
        $eventDate = htmlentities((string)$json_obj['date']);
   
        $stmt = $mysqli->prepare("SELECT title, date, time, id, tag FROM events WHERE date = ? AND (user_id = ? OR shareWith = ?)");
        
        if (!$stmt) {
            echo json_encode(array('success' => false, 'message' => "Database error: " . $mysqli->error));
            exit;
        }

        $stmt->bind_param('sii', $eventDate, $userID, $userID);
    }
    else if ($queryType == "byTag"){
        $eventTag = htmlentities((string)$json_obj['tag']);
   
        $stmt = $mysqli->prepare("SELECT title, date, time, id, tag FROM events WHERE tag = ? AND (user_id = ? OR shareWith = ?)");
        
        if (!$stmt) {
            echo json_encode(array('success' => false, 'message' => "Database error: " . $mysqli->error));
            exit;
        }

        $stmt->bind_param('sii', $eventTag, $userID, $userID);
    }
    else if ($queryType == "all") {
        $stmt = $mysqli->prepare("SELECT title, date, time, id, tag FROM events WHERE user_id = ? OR shareWith = ?");
        
        if (!$stmt) {
            echo json_encode(array('success' => false, 'message' => "Database error: " . $mysqli->error));
          exit;
        }
        $stmt->bind_param('ii', $userID, $userID);
    }
      
    $stmt->execute();
    $stmt->bind_result($eventTitle, $eventDate, $eventTime, $eventID, $eventTag);
    
    while($stmt->fetch()) {
        $events[] = array(
            "title" => $eventTitle,
            "date" => $eventDate,
            "time" => $eventTime,
            "id" => $eventID,
            "tag" => $eventTag
        );
    }
    
    $stmt->close();
    
    echo json_encode(array(
        "success" => true,
        "events" => $events,
        "message" => "Events retrieved successfully!"
    ));
    
    exit;

?>