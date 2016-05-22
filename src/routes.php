<?php
function call($controller, $action)
{
    // require the file that matches the controller name
    require_once('controllers/' . $controller . '_controller.php');

    // create a new instance of the needed controller
    switch ($controller)
    {
        case 'pages':
            $controller = new PagesController();
            break;
        case 'users':
            $controller = new UsersController();
            break;
        case 'admins':
            $controller = new AdminsController();
            break;
        case 'messages':
            $controller = new MessagesController();
            break;
    }

    // call the action
    $controller->{$action}();
}

// just a list of the controllers we have and their actions
// we consider those "allowed" values
$controllers = array(
    'pages' => ['home', 'error', 'userlockedout', 'invalidlogininfo', 'verificationsent', 'verificationnotsent', 'permissionDenied'],
    'users' => ['register', 'login', 'logout', 'home', 'goodbye', 'sendemail', 'pictureUpload', 'error', 'verify'],
    'admins' => ['listusers', 'ban', 'unban'],
    'messages' => ['newmessage', 'mymessages', 'sentmessages', 'error']);

// check that the requested controller and action are both allowed
// if someone tries to access something else he will be redirected to the error action of the pages controller
if (array_key_exists($controller, $controllers))
{
    if (in_array($action, $controllers[$controller]))
    {
        call($controller, $action);
    } else
    {
        call('pages', 'error');
    }
} else
{
    call('pages', 'error');
}
?>