<?php

class PagesController
{
    public function home()
    {
        $db = Db::getInstance();
        $username = $db->loadUserNameByID(1);
        require('views/pages/home.php');
    }


    public function register()
    {
        $db = Db::getInstance();
        $id = 1;
        $email = 'spam@spam.spam';
        $password = 'verybcrypt';
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

?>