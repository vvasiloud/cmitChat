<?php

if (!isset($_SESSION['sessionid'])) {
    session_start();
}
include_once '../dao/userDao.php';
include_once '../dao/channelDao.php';
include_once '../model/User.php';
include_once '../model/RegisteredUser.php';

$login = new UserDao();
$userobj = new RegisteredUser();
$channelDao = new ChannelDao();
$userobj->setUsername($_POST['username']);
$userobj->setPassword($_POST['password']);
$loginResult = $login->userLogin($userobj->getUsername(), $userobj->getPassword());
//echo $loginResult;

if ($loginResult === NULL) {
    echo 'Sorry, that username/password is invalid';
} else {
    $_SESSION['sessionid'] = $loginResult;
    $_SESSION['username'] = $userobj->getUsername();
    
    //Get current message count
    $messageCount = $channelDao->countMessages();
        foreach ($messageCount as $row) {
        $totalCount = $row['msgCount'];
    }

    //Unmark welcome message as read
    $totalCount= $totalCount-1;
    
    $_SESSION['msgCount'] = $totalCount;

    header('Location: ../chat.php');
}
?>