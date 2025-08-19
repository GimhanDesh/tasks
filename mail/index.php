<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$senderName = "Gimhan";
$senderMail = "gimhandd99@gmail.com";
$senderMobile = "0702122321";
$senderMessage = "hello";
$recieverMail = "gimhandesh123@gmail.com";

$username = "gimhandd99@gmail.com";
$password = "SLsvnorep@jiat2022";

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;  // Disable debug output in production
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Recipients
    $mail->setFrom('gimhandd99@gmail.com', 'MEDI_LAB');
    $mail->addAddress($recieverMail, 'MEDI_LAB');
    $mail->addReplyTo($senderMail, 'Information');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Get in Touch-Prescription Quotation';
    $mail->Body = '
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Quotation Details</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
 <h1>Hello</h1>
</body>
</html>

   ';
    $mail->AltBody = $senderMessage.', From: '.$senderName;

    $mail->send();

    header('Content-Type: application/json');
    echo json_encode(["success" => true, "message" => "Message sent"]);
} catch (Exception $e) {
    // Log the error for internal use
    error_log("Mailer Error: " . $mail->ErrorInfo);

    // Return a generic error message to the user
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Message could not be sent due to an internal error."]);
}
?>
