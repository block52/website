<?php
set_time_limit(30);
error_reporting(E_ALL);
include_once('admin/engine/phpmailer/class.phpmailer.php');
include_once('admin/engine/phpmailer/class.smtp.php');
include_once('admin/engine/phpmailer/PHPMailerAutoload.php');

$mail             = new PHPMailer();

$body             = 'TEST MAIL';

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "testerlethe@gmail.com";  // GMAIL username
$mail->Password   = "Lethe1453";            // GMAIL password

$mail->SetFrom('testerlethe@gmail.com', 'First Last');


$mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = "uslmesut@gmail.com";
$mail->AddAddress($address, "John Doe");


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
    
?>