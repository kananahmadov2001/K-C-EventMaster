<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo json_encode(array(
        "loggedin" => true,
        "username" => $_SESSION['username']
    ));
} else {
    echo json_encode(array(
        "loggedin" => false
    ));
}
?>