<?php

require_once('models/user.php');
require_once('models/message.php');

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
        $db = Db::getInstance();
        $user = $db->login($email, $password);
        if ($user) {
            $_SESSION[USER] = $user;
            header('location:?controller=users&action=home', true);
        } else ;
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