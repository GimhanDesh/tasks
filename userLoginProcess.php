<?php
session_start();
require "connection.php";

$email = $_POST["email"];
$password = $_POST["password"];

try {

    $result = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");
    $n = $result->num_rows;

    if ($n == 0) {
        $response = ["success" => false, "message" => "Invalid Credentials"];
    } else {
        $user = $result->fetch_assoc();
        $_SESSION["user"] = $user;
        $response = ["success" => true, "message" => "User Logged Successfully"];
    }


    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
