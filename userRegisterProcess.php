<?php

require "connection.php";

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$address = $_POST["address"];
$contact = $_POST["contact"];
$dob = $_POST["dob"];

try{
Database::iud("INSERT INTO `user` (`name`,`email`,`password`,`address`,`contact_no`,`dob`) VALUES ('".$name."','".$email."','".$password."','".$address."','".$contact."','".$dob."')");

$response = ["success"=>true,"message"=>"User Registered Successfully"];
echo json_encode($response);


}catch(Exception $e){
echo json_encode(["success"=>false,"message"=>$e->getMessage()]);
}




?>
