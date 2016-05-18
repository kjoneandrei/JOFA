<?php

require_once('models/user.php');
require_once('models/message.php');

/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/16/2016
 * Time: 12:19 PM
 */
class MessagesController
{
    public function newmessage()
    {
        $db = Db::getInstance();
        $recipient = $db->loadUserByUsername($_POST["recipient"]);
        $db->createMessage($_SESSION[USER]->getId(), $recipient->getId(), $_POST["header"], $_POST["body"]);
    }

    public function mymessages()
    {
        if (!isset($_SESSION[USER])) {
            return error;
        }
        $db = Db::getInstance();
        $messages = $db->loadMessageByUser($_SESSION[USER]->getId());
        require('views/messages/mymessages.php');
    }

    public function sentmessages()
    {
        if (!isset($_SESSION[USER])) {
            return error;
        }
        $db = Db::getInstance();
        $messages = $db->loadMessageBySender($_SESSION[USER]->getId());
        require('views/messages/sentmessages.php');
    }

    public function goodbye()
    {
        $username = $_GET['username'];
        require 'views/messages/goodbye.php';
    }

    /*
     * errors
     */
    public function invalidLoginInfo()
    {
        require('views/users/invalid.html');
    }

    public function error()
    {
        require('views/pages/error.php');
    }
}