<?php

require('../src/connection.php');
require('../src/models/user.php');
require('../src/ini.php');
/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/12/2016
 * Time: 3:06 PM
 */
class connectionTest extends PHPUnit_Framework_TestCase
{
    private  $db;
    private $generatedID = 'B8733B41-BF8C-465B-99E9-A45AE784065A';
    protected function setUp()
    {
        $this->db = Db::getInstance();
    }

    protected function tearDown()
    {
        $this->db = NULL;
    }

    public function testGetUserNameByID()
    {
        $this->assertEquals('GG', $this->db->loadUserNameByID(0));
    }

    public function testCreateUser()
    {
        $email = 'spam@spam.spam';
        $password = 'verybcrypt';
        $username = 'steve';
        $active = 0;
        $this->generatedID = $this->db->createUser($email, $password, $username, $active);
        $this->assertEquals('steve', $this->db->loadUserNameByID($this->generatedID));
    }

    public function testLoadUserByEmail(){
        $email = 'spam@spam.spam';
        $password = 'verybcrypt';
        $username = 'steve';
        $active = 0;
        $exp_user = new User($this->generatedID, $email, $password, $username, $active);
        $act_user = $this->db->loadUserByEmail('spam@spam.spam');
        $this->assertEquals($exp_user->getId(), $act_user->getId());
    }
}
