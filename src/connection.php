<?php

class Db extends PDO
{
    private static $instance = NULL;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            require_once('../dbconfig.php');
            if (isset($dbname) AND isset($dbuser) AND isset($dbpassword)) {
                self::$instance = new Db ('mysql:host=localhost;dbname=' . $dbname, $dbuser, $dbpassword, $pdo_options);
            } else die ('A valid database configuration was not found!');
        }
        return self::$instance;
    }

    /*
     * UserManager
     */

    public function loadUserNameByID($userID)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE ID=?");
        $sth->execute(array($userID));
        $userName = $sth->fetchColumn(3);
        return $userName;
    }

    public function loadUserById($userID)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE ID=?");
        $sth->execute(array($userID));
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            return User::fromRow($row);
        }
    }

    public function loadUserByUsername($username)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE USERNAME=?");
        $sth->execute(array($username));
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            return User::fromRow($row);
        }
    }

    public function loadUserByEmail($userEmail)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE EMAIL=?");
        $sth->execute(array($userEmail));
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            return User::fromRow($row);
        }
    }

    public function createUser($email, $password, $username)
    {
        $id = $this->generateUserID();
        $hashed_password = $this->hash_password($password);
        $active = 0;
        $statement = $this->prepare("INSERT INTO user(ID, EMAIL, PASSWORD, USERNAME, ACTIVE)
    VALUES(?, ?, ?, ?, ?)");
        $statement->execute(array($id, $email, $hashed_password, $username, $active));
        $this->verifyUserWithEmail($email, $username, $id);

        return $id;
    }

    public function deleteUser($id)
    {
        $sth = $this->prepare("DELETE FROM user WHERE ID=?");
        $sth->execute(array($id));
    }

    function hash_password($plainpw)
    {
        $options = [
            'cost' => 12,
        ];
        $hashed_password = password_hash($plainpw, PASSWORD_BCRYPT, $options) . "\n";
        return $hashed_password;
    }

    function generateUserID()
    {
        return trim($this->generateGUID(), '{}');
    }

    function generateGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);// "}"
            return $uuid;
        }
    }

    function login($email, $password)
    {
        $user = $this->loadUserByEmail($email);
        if (password_verify($password, $user->getPassword())) {
            return $user;
        } else {
            return false;
        }
    }

    /*
     * MessageManager
     */

    public function createMessage($senderID, $recipientID, $msg_header, $msg_body)
    {
        $id = $this->generateMessageID();
        $statement = $this->prepare("INSERT INTO message(ID, SENDER_USER_ID, RECIPIENT_USER_ID, DATE, MSG_HEADER, MSG_BODY)
    VALUES(?, ?, ?, ?, ?, ?)");
        $statement->execute(array($id, $senderID, $recipientID, date('Y-m-d H:i:s'), $msg_header, $msg_body));
        return $id;
    }

    public function loadMessageByUser($userID)
    {
        $sth = $this->prepare("SELECT * FROM message WHERE RECIPIENT_USER_ID=?");
        $sth->execute(array($userID));
        return $this->messageFetcher($sth);
    }

    public function loadMessageBySender($userID)
    {
        $sth = $this->prepare("SELECT * FROM message WHERE SENDER_USER_ID=?");
        $sth->execute(array($userID));
        return $this->messageFetcher($sth);
    }

    public function loadSenderByMessage($message)
    {
        $this->loadUserById($message->getSenderId());
    }

    public function loadRecipientByMessage($message)
    {
        $this->loadUserById($message->getRecipientId());
    }

    private function messageFetcher($sth)
    {
        $result = [];
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $message = Message::fromRow($row);
            $message->setSender($this->loadUserById($message->getSenderId()));
            $message->setRecipient($this->loadUserById($message->getRecipientId()));
            array_push($result, $message);
        }
        return $result;
    }

    function generateMessageID()
    {
        return trim($this->generateGUID(), '{}');
    }

    /*
     * AttemptManager
     */

    public function createAttempt($senderEmail, $date, $successful, $senderIp)
    {
        $statement = $this->prepare("INSERT INTO attempt(USER_EMAIL, SUCCESSFUL, DATE, IP)
    VALUES(?, ?, ?, ?)");
        $statement->execute(array($senderEmail, $date, $successful, $senderIp));
    }


    public function retriveAttepmtsByUser($userEmail)
    {
        $date = date('Y-m-d H:i:s', strtotime('-1 hour'));

        $statement = $this->prepare("SELECT * FROM attempt WHERE USER_EMAIL=? AND SUCCESSFUL=0 AND  DATE>? ");
        $statement->execute(array($userEmail, $date));
        return $this->attemptFetcher($statement);

    }

    private function attemptFetcher($statement)
    {
        $result = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            array_push($result, Attempt::fromRow($row));
        }

        return $result;
    }

    private function verifyUserWithEmail($email, $username, $hash)
    {
        $message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: ' . $username . '
------------------------
 
Please click this link to activate your account:
http://www.188.166.167.52.com/verify.php?email=' . $email . '&hash=' . $hash . '
 
';

        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreplyjofa@yahoo.com';                 // SMTP username
        $mail->Password = 'Password1234';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('noreplyjofa@yahoo.com', 'Verification Jofa account');
        $mail->addAddress($email, $username);     // Add a recipient
        $mail->addAddress($email);               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Jofa Account Verification';
        $mail->Body    = $message;
        $mail->AltBody = $message;

        if(!$mail->send()) {
            echo 'Verification email could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Your verification email has been sent. Please wait a few minutes and then activate your account';
        }


    }
}
?>