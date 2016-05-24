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
    /* @var $db Db */
    private $db;


    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function register()
    {
        $this->validateRegister();
        $email = $_POST["email"];
        $password = $_POST["password"];
        $username = $_POST["username"];
        $userId = $this->db->createUser($email, $password, $username);
        //$this->verifyUserWithEmail($email, $username, $userId);
    }

    private function verifyUserWithEmail($email, $username, $userId)
    {
        $message = getEmailMsg($username, $userId);
        $mail = new PHPMailer;
        require '../mailconfig.php';

        if ($mail->send())
        {
            reloc('pages', 'verificationSent');
        } else
        {
            reloc('pages', 'verificationNotSent');
            error_log($mail->ErrorInfo);
        }
    }

    public function login()
    {
        /* @var $user User */
        $email = $_POST["email"];
        $password = $_POST["password"];
        $user = $this->db->login($email, $password);
        if(!$user)
        {
            reloc('pages', 'invalidLoginInfo');
        }
        if ($this->db->isUserBlocked($email))
        {
            reloc('pages', 'userLockedOut');
        }
        if (!$user->isActive())
        {
            reloc('pages', 'inactive');
        }
        if ($user->isBanned())
        {
            reloc('pages', 'banned');
        }
        if ($user)
        {
            $_SESSION[USER] = $user;
            $_SESSION[TOKEN] = md5(uniqid(mt_rand(), true));
            $date = date('Y-m-d H:i:s');
            $senderIp = $_SERVER['REMOTE_ADDR'];
            $this->db->createAttempt($email, true, $date, $senderIp);
            reloc('users', 'home');
        }
    }


    private function validateRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            reloc('pages', 'error');
        }
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        {
            reloc('pages', 'error');
        }

        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["password"]) || strlen($_POST['password']) < 8)
        {
            reloc('pages', 'error');
        }
        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["username"]) || strlen($_POST['username']) < 4)
        {
            reloc('pages', 'error');
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
        $db->activateUser($user);
        require 'views/pages/verificationsuccessful.php';
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

    private function verifyPostRequestCSRF()
    {
        $this->verifyIdentity();
        if ($_POST[TOKEN] != $_SESSION[TOKEN])
        {
            reloc('pages', 'permissionDenied');
        }
    }

    private function verifyIdentity()
    {
        if (!isset($_SESSION[USER]))
        {
            reloc('pages', 'permissionDenied');
        }
    }

    public function pictureUpload()
    {
        $this->verifyPostRequestCSRF();
        $id = $_SESSION[USER]->getId();
        $imageFileType = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);

        //if they DID upload a file...
        if ($_FILES['fileToUpload']['name'])
        {
            //if no errors...
            if (!$_FILES['fileToUpload']['error'])
            {
                //now is the time to modify the future file name and validate the file
                $new_file_name = $id . "." . $imageFileType; //rename file
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"
                )
                {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $valid_file = false;
                } else
                {
                    $valid_file = true;
                }
                //if the file has passed the test
                if ($valid_file)
                {
                    //move it to where we want it to be
                    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], 'uploads/' . $new_file_name);
                    echo 'Congratulations!  Your file was accepted.';
                }
                $_SESSION[USER]->setImgPath($new_file_name);
                Db::getInstance()->setUserImgPath($_SESSION[USER]);
            } //if there is an error...
            else
            {
                //set that to be the returned message
               error_log($_FILES['fileToUpload']['error']);
            }
        }
    }

}