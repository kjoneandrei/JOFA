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
    private $successful;
    private $date;
    private $userIp;

    /**
     * Attempt constructor.
     * @param $userEmail
     * @param $date
     * @param $userIp
     * @param $successful
     */
    public function __construct($userEmail, $successful, $date, $userIp)
    {
        $this->userEmail = $userEmail;
        $this->successful = $successful;
        $this->date = $date;
        $this->userIp = $userIp;
    }

    public static function fromRow($row)
    {
        $instance = new self($row[USER_EMAIL], $row[SUCCESSFUL], $row[DATE], $row[IP]);
        return $instance;
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
    public function getSuccessful()
    {
        return $this->successful;
    }

    /**
     * @param mixed $successful
     */
    public function setSuccessful($successful)
    {
        $this->successful = $successful;
    }
}