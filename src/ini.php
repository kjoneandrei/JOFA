<?php
require_once('connection.php');
/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/16/2016
 * Time: 2:09 PM
 */

// PHP initializer
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

// App constants
define('USER', 'USER');
// DB constants
// USER
define("ID", "ID");
define("EMAIL", "EMAIL");
define("PASSWORD", "PASSWORD");
define("USERNAME", "USERNAME");
define("ACTIVE", "ACTIVE");
// MESSAGE
define("SENDER_USER_ID", "SENDER_USER_ID");
define("RECIPIENT_USER_ID", "RECIPIENT_USER_ID");
define("DATE", "DATE");
define("MSG_HEADER", "MSG_HEADER");
define("MSG_BODY", "MSG_BODY");
//ATEMPT
define("USER_EMAIL","USER_EMAIL");
define("IP","IP");
define("SUCCESSFUL","SUCCESSFUL");