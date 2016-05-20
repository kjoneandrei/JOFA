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
        $userIdToHash = $db->createUser($email, $password, $username);
        $this->verifyUserWithEmail($email, $username, $userIdToHash);
    }

    public function error()
    {
        require('views/pages/error.php');
    }

    private function verifyUserWithEmail($email, $username, $hash)
    {
        $message = getEmailMsg($username, $email, $hash);

        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreplyjofa@yahoo.com';                 // SMTP username
        $mail->Password = 'Password1234';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('noreplyjofa@yahoo.com', 'Verification Jofa account');
        $mail->addAddress($email, $username);     // Add a recipient
        $mail->addAddress($email);               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Jofa Account Verification';
        $mail->Body = $message;
        $mail->AltBody = $message;

        if (!$mail->send()) {
            echo 'Verification email could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Your verification email has been sent. Please wait a few minutes and then activate your account';
        }


    }

    public function login()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $date = date('Y-m-d H:i:s');
        $db = Db::getInstance();
        $senderIp = $_SERVER['REMOTE_ADDR'];
        $user = $db->login($email, $password);
        $attempts = $db->loadAttepmtsByUser($email);
        $attemptsCount = count($attempts);
        if ($attemptsCount >= 3) {
            $db->createAttempt($email, 0, $date, $senderIp);
            return $this->error();
        } else {
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

    public function verify()
    {
        $db = DB::getInstance();
        $user = $db->loadUserById($_GET["hash"]);

        $db->updateUser($user);
        echo "Succesfully activated your account";
    }

    public function listUsers()
    {
        if ($_SESSION[USER]->isAdmin()) {
            require 'views/users/listUsers.php';
        } else $this->permissionDenied();
    }

    /*
     * errors
     */

    public function permissionDenied()
    {
        require('views/pages/permissiondenied.php');
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

    public function invalidLoginInfo()
    {
        require('views/users/invalid.php');
    }
}