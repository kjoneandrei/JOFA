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
ini_set('file_uploads', 1);
error_reporting(-1);

// App constants
define('USER', 'USER');
define('TOKEN', 'csrf');

// DB constants

// USER
define("ID", "ID");
define("EMAIL", "EMAIL");
define("PASSWORD", "PASSWORD");
define("USERNAME", "USERNAME");
define("IMGPATH", "IMGPATH");
define("ACTIVE", "ACTIVE");
define("BANNED", "BANNED");
// MESSAGE
define("SENDER_USER_ID", "SENDER_USER_ID");
define("RECIPIENT_USER_ID", "RECIPIENT_USER_ID");
define("DATE", "DATE");
define("MSG_HEADER", "MSG_HEADER");
define("MSG_BODY", "MSG_BODY");
// ROLE
define("USERID", "USER_ID");
define("ROLE", "ROLE");
define("ADMIN_R", "admin");
define("USER_R", "user");
//ATTEMPT
define("USER_EMAIL", "USER_EMAIL");
define("IP", "IP");
define("SUCCESSFUL", "SUCCESSFUL");

function getEmailMsg($username, $userId)
{
    return '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: ' . $username . '
------------------------
 
Please click this link to activate your account:
https://188.166.167.52/?controller=users&action=verify&hash=' . $userId;
}

//Helper functions
function echox($string)
{
    echo htmlspecialchars($string, ENT_QUOTES);
}

function csrfTokenTest()
{
    if (!isset($_POST[TOKEN]) || $_POST[TOKEN] != $_SESSION[TOKEN])
    {
        header('location:?controller=pages&action=permissiondenied&reason=csrftoken');
    }
}

function reloc($controller, $action)
{
    header('location:?controller=' . $controller . '&action=' . $action);
    exit();
}
