<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/PHPMailer.php';

$success = false;
$userName = isset( $_POST['name'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['name'] ) : "";
$senderEmail = isset( $_POST['email'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email'] ) : "";
$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : "";

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
  //$mail->SMTPDebug = SMTP::DEBUG_OFF;SMTP::DEBUG_SERVER
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  $mail->isSMTP();
  $mail->Host       = 'mail.hidirektor.com.tr';
  $mail->SMTPAuth   = true;
  $mail->Username   = 'noreply@hidirektor.com.tr';
  $mail->Password   = '&#4?{oKWoOM0';
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;

  //Recipients
  $mail->setFrom('noreply@hidirektor.com.tr', 'hidirektor.com.tr');
  $mail->addAddress('hidirektor@gmail.com');

  // Content
  $mail->isHTML(false);
  $mail->Subject = "Talentia48h -- Yeni Başvuru";
  $mail->Body = "İsim: " . $userName . "\nE-Posta: " . $senderEmail . "\nMesaj: " . $message;

  $mail->send();
  echo "<script>window.location = 'index.html?success=1';</script>";
} catch (Exception $e) {
  echo "<script>window.location = 'index.html?error=1';</script>";
}
?>
