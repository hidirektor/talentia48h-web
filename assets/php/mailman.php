<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/PHPMailer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $to_email = "hidirektor@gmail.com";
  $subject = "Talentia48h Yeni Başvuru";

  // Sanitize input data
  $user_name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
  $user_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

  // Validate input data
  if (strlen($user_name) < 2) {
    $output = json_encode(array('type' => 'error', 'text' => 'Girilen isim soyisim çok kısa!'));
    die($output);
  }
  if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    $output = json_encode(array('type' => 'error', 'text' => 'Lütfen geçerli bir E-Posta adresi gir!'));
    die($output);
  }

  // Email body
  $message_body = $message . "\r\n\r\n-" . $user_name . "\r\nEmail: " . $user_email . "\r\n";

  // Send email using PHPMailer
  $mail = new PHPMailer(true);
  $mail->CharSet = 'UTF-8';

  try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'mail.hidirektor.com.tr';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@hidirektor.com.tr';
    $mail->Password   = '&#4?{oKWoOM0';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom($user_email, $user_name);
    $mail->addAddress($to_email);

    //Content
    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body    = $message_body;

    $mail->send();
    $output = json_encode(array('type' => 'message', 'text' => $user_name . ', başvurun için teşekkür ederiz :))'));
    die($output);
  } catch (Exception $e) {
    $output = json_encode(array('type' => 'error', 'text' => 'Başvurunuz alınamadı. Mail hatası: ' . $mail->ErrorInfo));
    die($output);
  }
}
?>
