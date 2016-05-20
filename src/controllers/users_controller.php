<?php

require_once('models/user.php');
require_once('models/message.php');
require_once('models/attempt.php');
require '../phpmailer/PHPMailerAutoload.php';


/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/16/2016
 * Time: 12:19 PM
 */
class UsersController
{
    //post only
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->error();
        }

        $db = Db::getInstance();
        $email = $_POST["email"];
        $password = $_POST["password"];
        $username = $_POST["username"];
        $db->createUser($email, $password, $username);
    }

    public function login()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $date = date('Y-m-d H:i:s');
        $db = Db::getInstance();
        $senderIp = $_SERVER['REMOTE_ADDR'];
        $user = $db->login($email, $password);
        $attempts = $db->retriveAttepmtsByUser($email);
        $attemptsCount = count($attempts);
        if ($attemptsCount>=3){
            $db->createAttempt($email, 0, $date, $senderIp);
            return $this->error();
        }
        else {
            if ($user) {
                $successful = true;
                $db->createAttempt($email, $successful, $date, $senderIp);
                $_SESSION[USER] = $user;
                header('location:?controller=users&action=home', true);
            } else {
                $successful = false;
                $db->createAttempt($email, $successful, $date, $senderIp);
            }
        }
    }

    public function logout()
    {
        $username = $_SESSION[USER]->getUsername();
        session_destroy();
        header('location:?controller=users&action=goodbye&username=' . $username, true);
    }

    public function home()
    {
        require('views/users/home.php');
    }

    public function goodbye()
    {
        $username = $_GET['username'];
        require 'views/users/goodbye.php';
    }

    /*
     * errors
     */
    public function invalidLoginInfo()
    {
        require('views/users/invalid.php');
    }

    public function error()
    {
        require('views/pages/error.php');
    }

   public function sendemail(){
       $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

       $mail->isSMTP();                                      // Set mailer to use SMTP
       $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
       $mail->SMTPAuth = true;                               // Enable SMTP authentication
       $mail->Username = 'noreplyjofa@yahoo.com';                 // SMTP username
       $mail->Password = 'Password1234';                           // SMTP password
       $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
       $mail->Port = 587;                                    // TCP port to connect to

       $mail->setFrom('noreplyjofa@yahoo.com', 'Mailer');
       $mail->addAddress('andy_goal2007@yahoo.com', 'Joe User');     // Add a recipient
       $mail->addAddress('andy_goal2007@yahoo.com');               // Name is optional
       $mail->addReplyTo('info@example.com', 'Information');
       $mail->addCC('cc@example.com');
       $mail->addBCC('bcc@example.com');

       $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
       $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
       $mail->isHTML(true);                                  // Set email format to HTML

       $mail->Subject = 'Yahoo mail verification try';
       $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
       $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

       if(!$mail->send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
       } else {
           echo 'Message has been sent';
       }
}
}