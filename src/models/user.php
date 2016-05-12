<?php

/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/12/2016
 * Time: 4:13 PM
 */
class user
{
    private $id;
    private $email;
    private $password;
    private $username;
    private $active;

    public function __construct($id, $email, $password, $username, $active)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->active = $active;
    }


}