<?php

require('../src/connection.php');
require('../src//models/user.php');
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
        $generatedID = $this->db->createUser($email, $password, $username, $active);
        $this->assertEquals('steve', $this->db->loadUserNameByID($generatedID));
    }

    public function testLoadUserByEmail(){
        $id = 1;
        $email = 'spam@spam.spam';
        $password = 'verybcrypt';
        $username = 'steve';
        $active = 0;
        $exp_user = new User($id, $email, $password, $username, $active);
        $act_user = $this->db->loadUserByEmail('spam@spam.spam');
        $this->assertEquals($exp_user->getId(), $act_user->getId());
    }
}
