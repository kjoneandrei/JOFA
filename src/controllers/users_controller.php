<?php

require_once('models/user.php');
require_once('models/message.php');
require_once('models/attempt.php');


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
            return error();
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
}