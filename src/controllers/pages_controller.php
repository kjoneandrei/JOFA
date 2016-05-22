<?php

class PagesController
{
    public function verificationSent()
    {
        require 'views/pages/verificationsent.php';
    }

    public function verificationNotSent()
    {
        require 'views/pages/verificationnotsent.php';
    }

    public function home()
    {
        require('views/pages/home.php');
    }

    public function permissionDenied()
    {
        require('views/pages/permissiondenied.php');
    }

    public function error()
    {
        require('views/pages/error.php');
    }
}

?>