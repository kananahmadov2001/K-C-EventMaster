<?php
    require 'database.php';

    header("Content-Type: application/json"); 

        $json_str = file_get_contents('php://input');

    $json_obj = json_decode($json_str, true);

    $username = htmlentities((string)$json_obj['username']);
    $password = htmlentities((string)$json_obj['password']);
    
    // Carryover from module 3 to get relevant values from db
    $stmt = $mysqli->prepare("SELECT id, password_hash FROM users WHERE username = ?");
      if (!$stmt) {
        echo "Database error: " . $mysqli->error;
        exit;
      }
      
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($id, $password_hash);
      $stmt->fetch();


    if($stmt->num_rows > 0 && password_verify($password, $password_hash)){
        ini_set("session.cookie_httponly", 1);

        session_start();

        $previous_ua = @$_SESSION['useragent'];
        $current_ua = $_SERVER['HTTP_USER_AGENT'];

        if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
            die("Session hijack detected");
        }else{
            $_SESSION['useragent'] = $current_ua;
        }

        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
        $token =  $_SESSION['token'];

        echo json_encode(array(
            "success" => true,
            "username" => $username,
            "token" => $token
        ));
        exit;
    }else{
        echo json_encode(array(
            "success" => false,
            "message" => "Incorrect Username or Password"
        ));
        exit;
    }
?>