<?php

if (!isset($_SESSION['sessionid'])) {
    session_start();
}
header('Content-type: application/json');
$data = array();

require_once '../dao/channelDao.php';
require_once '../dao/userDao.php';

//Boolean that returns the state of current user
$userdao = new UserDao();
$isActive = $userdao->isActive($_SESSION['sessionid']);
if ($isActive == 0) {

    $logout = new UserDao();
    $logout->userLogout($_SESSION['sessionid']);
    session_destroy();
    $data['result'] = true;
    echo json_encode($data);
} else {
    $data['result'] = false;
    echo json_encode($data);
}
?>
