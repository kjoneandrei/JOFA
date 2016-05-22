<?php

class PagesController
{
    public function home()
    {
        require('views/pages/home.php');
    }

    public function error()
    {
        require('views/pages/error.php');
    }
}

?>