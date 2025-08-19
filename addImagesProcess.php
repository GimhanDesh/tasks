<?php
session_start();
require "connection.php";

if (!isset($_SESSION["user"]["id"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$statusResult = Database::search("SELECT `id` FROM `status` WHERE `status`='Pending'");
if ($statusResult->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "Can't find status"]);
    exit;
}

$statusResultData = $statusResult->fetch_assoc();
$pendingStatus = (int) $statusResultData["id"];
$userId = (int) $_SESSION["user"]["id"];

Database::iud("INSERT INTO `prescription`(`user_id`,`status_id`) VALUES('$userId','$pendingStatus')");
$prescriptionId = Database::$connection->insert_id;

$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['image'])) {
    $files = $_FILES['image'];
    $totalFiles = count($files['name']);
    $uploadedFiles = [];

    if ($totalFiles > 5) {
        echo json_encode(["success" => false, "message" => "You can only upload up to 5 files."]);
        exit;
    }

    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = basename($files["name"][$i]);
        $targetFile = $targetDir . time() . "_" . $fileName;

        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($fileType, $allowed)) {
            continue;
        }

        if (move_uploaded_file($files["tmp_name"][$i], $targetFile)) {
            $uploadedFiles[] = $targetFile;

            Database::iud("INSERT INTO `image`(`Prescription_id`,`path`) VALUES('$prescriptionId','$targetFile')");
        }
    }

    if (!empty($uploadedFiles)) {
        echo json_encode([
            "success" => true,
            "message" => "Prescription created and files uploaded."

        ]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "No valid files uploaded."]);
        exit;
    }
} else {
    echo json_encode(["success" => false, "message" => "No files received."]);
    exit;
}
