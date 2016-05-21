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

    public function listusers()
    {
        if ($_SESSION[USER]->isAdmin()) {
            $users = $this->db->loadAllUsers();
            require 'views/admins/listUsers.php';
        } else $this->permissionDenied();
    }

    public function permissionDenied()
    {
        require('views/pages/permissiondenied.php');
    }

    public function ban()
    {
        if ($_SESSION[USER]->isAdmin()) {
            $this->db->banUser($_GET['userid']);
            header('location:?controller=admins&action=listusers', true);
        }
    }

    public function unBan()
    {
        if ($_SESSION[USER]->isAdmin()) {
            $this->db->unbanUser($_GET['userid']);
            header('location:?controller=admins&action=listusers', true);
        }
    }

    /*
     * errors
     */

    public function home()
    {
        require('views/users/home.php');
    }
}