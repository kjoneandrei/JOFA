<?php
  class PagesController {
    public function home() {
      $first_names = array('Ferenc','Johannes','Oliver', 'Andrei');
      shuffle($first_names);
      $first_name = $first_names[0];

      $last_names = array('Normann Jensen','Hammerl','Arnits', 'Hogea');
      shuffle($last_names);
      $last_name  = $last_names[0];
      require_once('views/pages/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>