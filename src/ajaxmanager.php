<?php
if (is_ajax()) {
    require_once 'ini.php';
    require_once 'connection.php';
    
    if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        $action = $_POST["action"];
        switch ($action) { //Switch case for value of action
            case "loadUserNameId":
                loadUserNameId();
                break;
        }
    }
}
//Function to check if the request is an AJAX request
function is_ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function loadUserNameId()
{
    $db = Db::getInstance();
    $return = json_encode($db->loadAllUserNameId());
    echo $return;
}

?>