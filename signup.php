<?php
if (isset($_SESSION['sessionid'])) {
    session_start();
    header('Location:chat.php');
}
include 'views/signupForm.php';
?>