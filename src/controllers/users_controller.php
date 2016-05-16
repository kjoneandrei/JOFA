<?php

require('models/user.php');

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
        echo '<script>alert("very registered");</script>';
    }

    public function login()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $db = Db::getInstance();
        $user = $db->login($email, $password);
        if ($user) {
            session_start();
            $_SESSION[USER] = $user;
            require('views/users/home.php');
        } else echo 'no good';
    }

    public function invalidLoginInfo()
    {
        require('views/users/invalid.html');
    }

    public function logout()
    {
        session_destroy();
    }

    public function error()
    {
        require('views/pages/error.php');
    }
}