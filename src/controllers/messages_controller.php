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
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function newMessage()
    {
        $this->verifyRequestCSRF();
        $this->db->createMessage($_SESSION[USER]->getId(), $_POST['recipient'], $_POST["header"], $_POST["body"]);
        reloc('messages', 'sentMessages');
    }
    public function myMessages()
    {
        $this->verifyRequest();
        $messages = $this->db->loadMessageByUser($_SESSION[USER]->getId());
        require('views/messages/mymessages.php');
    }

    public function sentMessages()
    {
        $this->verifyRequest();
        $messages = $this->db->loadMessageBySender($_SESSION[USER]->getId());
        require('views/messages/sentmessages.php');
    }

    private function verifyRequestCSRF()
    {
        $this->verifyRequest();
        if ($_POST[TOKEN] == $_SESSION[TOKEN])
        {
            return;
        } else
        {
            reloc('pages', 'permissionDenied');
        }
    }

    private function verifyRequest()
    {
        if (isset($_SESSION[USER]))
        {
            return;
        } else
        {
            reloc('pages', 'permissionDenied');
        }
    }
}