<?php

require "connection.php";

$PrescriptionId = $_POST["id"];
$statusId = $_POST["status"];

Database::iud("UPDATE `prescription` SET `status_id`='".$statusId."' WHERE `prescription`.`id`='".$PrescriptionId."';");

echo json_encode(["success" => true,"message" => "Successfully Status changed"]);

?>