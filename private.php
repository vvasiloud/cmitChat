<?php

require_once 'model/Channel.php';
require_once 'model/PrivateChannel.php';

if (!isset($_SESSION)) {
    session_start();
    global $userid;
    $userid = $_GET["id"];
    //$_SESSION['listener_id'] = $userid;
    echo $userid;

    if (!isset($_SESSION['sessionid'])) {
        header('Location: login.php');
    }

    include 'views/privateForm.php';

//include( dirname(__FILE__) .'/views/chatForm.php');
}
?>