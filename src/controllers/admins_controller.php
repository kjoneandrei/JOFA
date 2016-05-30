<?php

require_once('models/user.php');
require_once('models/message.php');
require_once('models/attempt.php');


/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/16/2016
 * Time: 12:19 PM
 */
class AdminsController
{
    /* @var $db Db */
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function listUsers()
    {
        $this->verifyIdentity(); // this method is not vulnerable to CSRF because of its nature
        $users = $this->db->loadAllUsers();
        require 'views/admins/listUsers.php';
    }

    public function ban()
    {
        $this->verifyRequest(); // checks the token in the URL, reroutes to permissionDenied if fails
        $this->db->banUser($_POST['userid']);;
        reloc('admins', 'listUsers');
    }

    public function unBan()
    {
        $this->verifyRequest();
        $this->db->unbanUser($_POST['userid']);
        reloc('admins', 'listUsers');
    }

    private function verifyRequest()
    {
        $this->verifyIdentity();
        if ($_POST[TOKEN] != $_SESSION[TOKEN])
        {
            reloc('pages', 'permissionDenied');
        }
    }

    private function verifyIdentity()
    {
        if (!$_SESSION[USER]->isAdmin())
        {
            reloc('pages', 'permissionDenied');
        }
    }
}