<?php
  class PagesController {
    public function home() {
      require_once ('../connection.php');
      $db = Db::getInstance();
      echo ' oh noe';
      $username = $db::loadUserName(0);
      require_once('views/pages/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>