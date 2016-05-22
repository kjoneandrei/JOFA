<?php
/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/19/2016
 * Time: 9:02 AM
 */
if (isset($messages)) {
    foreach ($messages as &$message) {
        require 'views/messages/message.php';
    }
}
    