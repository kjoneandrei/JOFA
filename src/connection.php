<?php
  class Db {
    private static $instance = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        require_once('../dbconfig.php');
        if (isset($dbname) AND isset($dbuser) AND isset($dbpassword)) {
          self::$instance = new PDO('mysql:host=localhost;dbname='.$dbname, $dbuser, $dbpassword, $pdo_options);
        }
        else die ('A valid database configuration was not found!');
      }
      return self::$instance;
    }
  }
?>