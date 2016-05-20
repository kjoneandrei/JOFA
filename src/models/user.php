<?php

/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/12/2016
 * Time: 4:13 PM
 */
class User
{
    private $id;
    private $email;
    private $password;
    private $username;
    private $active;

    private $roles;

    public function __construct($id, $email, $password, $username, $active)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->active = $active;
    }

    public static function fromRow($row)
    {
        $instance = new self($row[ID], $row[EMAIL], $row[PASSWORD], $row[USERNAME], $row[ACTIVE]);
        return $instance;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function isAdmin()
    {
        return in_array(ADMIN_R, $this->roles);
    }


}