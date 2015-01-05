<?php

if (!isset($_SESSION['sessionid'])) {
    session_start();
}
include_once '../dao/userDao.php';

$logout = new UserDao();
$userid = $_SESSION['sessionid'];
$logout->userLogout($userid);

session_destroy();

header('Location: ../index.php');
?>