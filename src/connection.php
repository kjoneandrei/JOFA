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

    public function createUser($email, $password, $username)
    {
        $id = $this->generateUserID();
        $hashed_password = $this->hash_password($password);
        $active = 0;
        $sth = $this->prepare("INSERT INTO user(ID, EMAIL, PASSWORD, USERNAME, ACTIVE)
    VALUES(?, ?, ?, ?, ?)");
        $sth->execute(array($id, $email, $hashed_password, $username, $active));
        createRole($id);
        return $id;
    }

    public function loadAllUsers()
    {
        $sth = $this->prepare("SELECT * FROM user");
        $sth->execute();
        return $this->userFetcher($sth);
    }

    public function loadUserByEmail($userEmail)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE EMAIL=?");
        $sth->execute(array($userEmail));
        return $this->userFetcher($sth)[0];
    }

    public function loadUserById($userID)
    {
        $sth = $this->prepare("SELECT * FROM user WHERE ID=?");
        $sth->execute(array($userID));
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            return User::fromRow($row);
        }
    }

    private function userFetcher($sth)
    {
        $result = [];
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $user = User::fromRow($row);
            $user->setRoles($this->loadRoles($user->getId()));
            array_push($result, $user);
        }
        return $result;
    }

    public function loadRoles($userId)
    {
        $sth = $this->prepare("SELECT * from role WHERE USER_ID = ?");
        $sth->execute(array($userId));
        return $this->roleFetcher($sth);
    }

    private function roleFetcher($sth)
    {
        $roles = [];
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            array_push($roles, $row[ROLE]);
        }
        return $roles;
    }

    public function activateUser($user)
    {
        $active = 1;
        $sth = $this->prepare("UPDATE user SET ACTIVE = ? WHERE ID = ?");
        $sth->execute(array($active, $user->getId()));
    }

    public function setUserImgPath($user)
    {
        $sth = $this->prepare("UPDATE user SET IMGPATH = ? WHERE ID = ?");
        $sth->execute(array($user->getImgPath(), $user->getId()));
    }

    public function banUser($userId)
    {
        $sth = $this->prepare("UPDATE user SET BANNED = ? WHERE ID = ?");
        $sth->execute(array(1, $userId));
    }

    public function unbanUser($userId)
    {
        $sth = $this->prepare("UPDATE user SET BANNED = ? WHERE ID = ?");
        $sth->execute(array(0, $userId));
    }

    // loads assoc array of id+username for the messagemodal
    public function loadAllUserNameId()
    {
        $sth = $this->prepare("SELECT ID, USERNAME FROM user");
        $sth->execute();
        $result = [];
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $user = array(
                "id" => htmlspecialchars($row[ID]),
                "username" => htmlspecialchars($row[USERNAME]));
            array_push($result, $user);
        }
        return $result;
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

    function hash_password($plainpw)
    {
        $options = [
            'cost' => 12,
        ];
        $hashed_password = password_hash($plainpw, PASSWORD_BCRYPT, $options) . "\n";
        return $hashed_password;
    }

    public function deleteUser($id)
    {
        $sth = $this->prepare("DELETE FROM user WHERE ID=?");
        $sth->execute(array($id));
    }

    function login($email, $password)
    {
        $user = $this->loadUserByEmail($email);
        if ($user->isBanned()) {
            echo 'banned';
            return false;
        }
        if (!$user->isActive()) {
            echo 'inactive';
            return false;
        }
        if (password_verify($password, $user->getPassword())) {
            echo 'user';
            return $user;
        } else {
            echo 'wrongpass';
            return false;
        }
    }

    /*
     * MessageManager
     */

    public function createMessage($senderID, $recipientID, $msg_header, $msg_body)
    {
        $id = $this->generateMessageID();
        $sth = $this->prepare("INSERT INTO message(ID, SENDER_USER_ID, RECIPIENT_USER_ID, DATE, MSG_HEADER, MSG_BODY)
    VALUES(?, ?, ?, ?, ?, ?)");
        $sth->execute(array($id, $senderID, $recipientID, date('Y-m-d H:i:s'), $msg_header, $msg_body));
        return $id;
    }

    function generateMessageID()
    {
        return trim($this->generateGUID(), '{}');
    }

    public function loadMessageByUser($userID)
    {
        $sth = $this->prepare("SELECT * FROM message WHERE RECIPIENT_USER_ID=?");
        $sth->execute(array($userID));
        return $this->messageFetcher($sth);
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

    public function loadMessageBySender($userID)
    {
        $sth = $this->prepare("SELECT * FROM message WHERE SENDER_USER_ID=?");
        $sth->execute(array($userID));
        return $this->messageFetcher($sth);
    }

    /*
     * RoleManager
     */

    public function loadSenderByMessage($message)
    {
        $this->loadUserById($message->getSenderId());
    }

    public function loadRecipientByMessage($message)
    {
        $this->loadUserById($message->getRecipientId());
    }

    public function createRole($userId, $role)
    {
        $sth = $this->prepare("INSERT INTO role VALUES(?, ?)");
        $sth->execute(array($userId, $role));
    }

    public function isAdmin($userId)
    {
        $sth = $this->prepare("SELECT * from role WHERE USER_ID = ? AND ROLE = ?");
        $sth->execute(array($userId, ADMIN_R));
        return $sth->rowCount() > 0;

    }

    /*
     * AttemptManager
     */

    public function createAttempt($senderEmail, $date, $successful, $senderIp)
    {
        $sth = $this->prepare("INSERT INTO attempt(USER_EMAIL, SUCCESSFUL, DATE, IP)
    VALUES(?, ?, ?, ?)");
        $sth->execute(array($senderEmail, $date, $successful, $senderIp));
    }

    public function isUserBlocked($userEmail)
    {
        $date = date('Y-m-d H:i:s', strtotime('-1 hour'));

        $sth = $this->prepare("SELECT * FROM attempt WHERE USER_EMAIL=? AND SUCCESSFUL=0 AND  DATE>? ORDER BY DATE DESC");
        $sth->execute(array($userEmail, $date));
        $attempts = $this->attemptFetcher($sth);
        $counter = 0;
        foreach ($attempts as &$attempt) {
            echo $attempt->getSuccessful();
            if ($attempt->getSuccessful()) {
                return false;
            }
            if (!$attempt->getSuccessful()) {
                $counter++;
                if ($counter >= 3) return true;
            }
        }
        return false;

    }

    private function attemptFetcher($sth)
    {
        $result = [];

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            array_push($result, Attempt::fromRow($row));
        }

        return $result;
    }


}

?>