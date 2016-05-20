<?php

class PagesController
{
    public function home()
    {
        $db = Db::getInstance();
        $username = $db->loadUserNameByID(1);
        require('views/pages/home.php');
    }

    public function error()
    {
        require('views/pages/permissiondenied.php');
    }
}

?>