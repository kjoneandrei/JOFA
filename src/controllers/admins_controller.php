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

    /**
     * AdminsController constructor.
     */
    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function listUsers()
    {
        $this->verifyRequest();
        $users = $this->db->loadAllUsers();
        require 'views/admins/listUsers.php';
    }

    public function ban()
    {
        $this->verifyRequest();
        $this->db->banUser($_GET['userid']);
        reloc('admins', 'listUsers');
    }

    public function unBan()
    {
        $this->verifyRequest();
        $this->db->unbanUser($_GET['userid']);
        reloc('admins', 'listUsers');
    }

    private function verifyRequest()
    {
        if ($_SESSION[USER]->isAdmin() && $_GET[TOKEN] == $_SESSION[TOKEN])
        {
            return;
        } else
        {
            reloc('pages', 'permissionDenied');
        }
    }
}