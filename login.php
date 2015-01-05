<?php
if (!isset($_SESSION['sessionid'])) {
    session_start();
    include 'views/loginForm.php';
    //include( dirname(__FILE__) . '/views/loginForm.php' );
} else {
    session_start();
    header('Location: chat.php');
}
?>