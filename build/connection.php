<?php
  class Db extends PDO{
    private static $instance = NULL;
    
    public static function getInstance() {
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        require_once('../dbconfig.php');
        if (isset($dbname) AND isset($dbuser) AND isset($dbpassword)) {
          self::$instance = new Db ('mysql:host=localhost;dbname='.$dbname, $dbuser, $dbpassword, $pdo_options);
        }
        else die ('A valid database configuration was not found!');
      }
      return self::$instance;
    }
    public function loadUserName($userID){
      return "UserName"; // Andrei pls :D
    }
  }
?>