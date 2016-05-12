<?php
  class PagesController {
    public function home() {
      $db = Db::getInstance();
      $username = $db::loadUserName(0);
      require('views/pages/home.php');
    }

    public function error() {
      require('views/pages/error.php');
    }
  }
?>