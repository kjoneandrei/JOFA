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


    private function verifyUserWithEmail($email, $username, $hash)
    {
        $message = getEmailMsg($username, $email, $hash);

        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreplyjofajofa@yahoo.com';                 // SMTP username
        $mail->Password = 'ThisIsNotMyPassword1212';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('noreplyjofajofa@yahoo.com', 'Verification Jofa account');
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

    public function pictureUpload()
    {
        $id = $_SESSION[USER]->getId();
        $imageFileType = pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION);

        //if they DID upload a file...
        if($_FILES['fileToUpload']['name'])
        {
            //if no errors...
            if(!$_FILES['fileToUpload']['error'])
            {
                //now is the time to modify the future file name and validate the file
                $new_file_name = $id; //rename file
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $valid_file = false;
                }
                else{
                    $valid_file = true;
                }
                //if the file has passed the test
                if($valid_file)
                {
                    //move it to where we want it to be
                    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], 'uploads/'.$new_file_name);
                     echo 'Congratulations!  Your file was accepted.';
                }
            }
            //if there is an error...
            else
            {
                //set that to be the returned message
                echo 'Ooops!  Your upload triggered the following error:  '.$_FILES['fileToUpload']['error'];
            }
        }
        }
    


}