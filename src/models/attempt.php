<?php

/**
 * Created by PhpStorm.
 * User: andreihogea
 * Date: 19/05/16
 * Time: 17:52
 */
class Attempt
{

    private $userEmail;
    private $date;
    private $userIp;
    private $succesful;

    /**
     * Attempt constructor.
     * @param $succesful
     * @param $userIp
     * @param $date
     * @param $userEmail
     */
    public function __construct($succesful, $userIp, $date, $userEmail)
    {
        $this->succesful = $succesful;
        $this->userIp = $userIp;
        $this->date = $date;
        $this->userEmail = $userEmail;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getUserIp()
    {
        return $this->userIp;
    }

    /**
     * @param mixed $userIp
     */
    public function setUserIp($userIp)
    {
        $this->userIp = $userIp;
    }

    /**
     * @return mixed
     */
    public function getSuccesful()
    {
        return $this->succesful;
    }

    /**
     * @param mixed $succesful
     */
    public function setSuccesful($succesful)
    {
        $this->succesful = $succesful;
    }


    public static function fromRow($row)
    {
        $instance = new self($row[USER_EMAIL], $row[SUCCESSFUL], $row[DATE], $row[IP]);
        return $instance;
    }
}