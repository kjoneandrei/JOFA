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

    public function loadUserNameByID($userID)
    {
        $sql = 'SELECT * FROM user WHERE ID = ' . $userID;
        foreach ($this->query($sql) as $row) {
            return $row['USERNAME'];
        }
    }

    public function createUser($id, $email, $password, $username, $active)
    {
        $statement = $this->prepare("INSERT INTO user(ID, EMAIL, PASSWORD, USERNAME, ACTIVE)
    VALUES(?, ?, ?, ?, ?)");
        $statement->execute(array($id, $email, $password, $username, $active));
    }
}

?>