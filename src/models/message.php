<?php

/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/12/2016
 * Time: 4:13 PM
 */
class Message
{
    private $id;
    private $sender_id;
    private $recipient_id;
    private $date;
    private $msg_header;
    private $msg_body;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * @return mixed
     */
    public function getRecipientId()
    {
        return $this->recipient_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getMsgHeader()
    {
        return $this->msg_header;
    }

    /**
     * @return mixed
     */
    public function getMsgBody()
    {
        return $this->msg_body;
    }

    public function __construct($id, $sender_id, $recipient_id, $date, $msg_header, $msg_body)
    {
        $this->id = $id;
        $this->sender_id = $sender_id;
        $this->recipient_id = $recipient_id;
        $this->date = $date;
        $this->msg_header = $msg_header;
        $this->msg_body = $msg_body;
    }

    public static function fromRow($row)
    {
        $instance = new self($row[ID], $row[SENDER_USER_ID], $row[RECIPIENT_USER_ID], $row[DATE], $row[MSG_HEADER], $row[MSG_BODY]);
        return $instance;
    }


}