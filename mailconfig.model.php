<?php
$mail->isSMTP();
$mail->Host = 'smtp.mail.yahoo.com';
$mail->SMTPAuth = true;
$mail->Username = 'noreplyjofajofa@yahoo.com';
$mail->Password = 'ThisIsNotMyPassword1212';
$mail->SMTPSecure = 'tls';
$mail->Port = 465;
$mail->setFrom('noreplyjofajofa@yahoo.com', 'Verification Jofa account');
$mail->addAddress($email, $username);
$mail->isHTML(true);

$mail->Subject = 'Jofa Account Verification';
$mail->Body = $message;
$mail->AltBody = $message;