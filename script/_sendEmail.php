<?php
require '../vendor/autoload.php';

function sendEmail($to,$sub,$body){
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  $mail->IsSMTP(); // enable SMTP

  $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true; // authentication enabled
  $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465; // or 587

  $mail->Username = "multimediacenter@uobabylon.edu.iq";
  $mail->Password = "!@#ASD123";
  $mail->SetFrom("multimediacenter@uobabylon.edu.iq");
  $mail->Subject = $sub;
  $mail->Body = $body;
  $mail->CharSet = 'UTF-8';
  $mail->IsHTML(true);
  $mail->AddAddress($to);
  if(!$mail->Send()) {
    return false;
  } else {
    return true;
  }
}
?>