<?php
session_start();
require_once '../dao/channelDao.php';
require_once '../model/Channel.php';
require_once '../model/PublicChannel.php';

$chatDao = new ChannelDao();
$channel = new PublicChannel();

$channel->setChatText($_POST['chatText']);
$channel->setUserid($_SESSION['sessionid']);

$chatText = $channel->getChatText();
$userid = $channel->getUserid();

$chatMessage = $chatDao->channelSendPublic($chatText, $userid);
//header('Location: ../chat.php');
?>