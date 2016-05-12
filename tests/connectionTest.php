<?php

/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/12/2016
 * Time: 3:06 PM
 */
class connectionTest extends PHPUnit_Framework_TestCase
{
    private  $db;
    protected function setUp()
    {
        include_once('../src/connection.php');
        $this->db = Db::getInstance();
    }

    public function testGetUserNameByID()
    {
        $this->assertEquals('GG', $this->db->loadUserNameByID(0));
    }

    public function testCreateUser()
    {
        $id = 1;
        $email = 'spam@spam.spam';
        $password = 'verybcrypt';
        $username = 'steve';
        $active = 0;
        $this->db->createUser($id, $email, $password, $username, $active);
        $this->assertEquals('steve', $this->db->loadUserNameByID($id));
    }
}
