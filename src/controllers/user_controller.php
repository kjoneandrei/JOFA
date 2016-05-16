<?php

/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/16/2016
 * Time: 12:19 PM
 */
class user_controller
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
        $username = 'gasd';
        $active = 0;
        $db->createUser($id, $email, $password, $username, $active);
        echo '<script>alert("very registered");</script>';
    }

    public function error()
    {
        require('views/pages/error.php');
    }
}