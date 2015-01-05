<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once '../dao/channelDao.php';
require_once '../model/Channel.php';
require_once '../model/PrivateChannel.php';

$userid = $_GET["id"];
//function sendPrivateMessage($userid) {
$chatDao = new ChannelDao();
$channel = new PrivateChannel();

$channel->setUserid($_SESSION['sessionid']);
$channel->setChatText($_POST['chatText']);

$chatText = $channel->getChatText();
$userspeaker = $channel->getUserid();

$chatMessage = $chatDao->channelSendPrivate($chatText, $userspeaker, $userid);
//header("Location: ../private.php?id=".$userid);
//header('Location: ' . $_SERVER['HTTP_REFERER']);
//}
?>