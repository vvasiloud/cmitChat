<?php

if (!isset($_SESSION)) {
    session_start();
}
//header('Content-Type: text/event-stream');
//header('Cache-Control: no-cache');
require_once '../dao/channelDao.php';
require_once '../model/Channel.php';
require_once '../model/PrivateChannel.php';
require_once '../model/User.php';
require_once '../model/RegisteredUser.php';

//function getPrivateChat($userid) {
$chatDao = new ChannelDao();
$user = new RegisteredUser();
$privateChannel = new PrivateChannel();
$userid = $_GET["id"];
$privateChannel->setUserid($_SESSION['sessionid']);
$idspeaker = $privateChannel->getUserid();

$privateChannel->setUseridListener($userid);
//$privateChannel->setUseridListener($_SESSION['listener_id']);
$idlistener = $privateChannel->getUseridListener();
$date = date_create();
date_sub($date, date_interval_create_from_date_string('3 seconds'));
$serverTime = date_format($date, 'Y-m-d H:i:s');



function showPrivateChatmessages($chatPrivateMessages) {
    if ($chatPrivateMessages != NULL) {
        //Populate an array of Channel Objects from the query
        foreach ($chatPrivateMessages as $row) {
            $channel = new PrivateChannel();
            $channel->setUserid($row['usernameSpeaker']);
            $channel->setChatText($row['chat_text']);
            $channel->setTimestamp($row['timestamp']);
            $channelPrivateMessages[] = $channel;
        }

        //Show the list
        foreach ($channelPrivateMessages as $obj) {
            $timestamp = $obj->getTimestamp();
            $username = $obj->getUserid();
            $chattext = htmlentities($obj->getChatText()); //prevent html injection
            echo "<div class='chatMessage'> $timestamp &nbsp $username: &nbsp  $chattext<br></div> ";
        }
    } else {
        //echo 'You have no messages yet...';
        // sleep(2);
    }
}

$data = $chatDao->channelRecievePrivate($serverTime, $idspeaker, $idlistener );
showPrivateChatmessages($data);
$chatDao->markAsRead($idlistener, $idspeaker);
/*//dublicate messages check
if ($data != NULL) {
    foreach ($data as $row) {
        $maxMsgId = $row['id'];  
    }
    $privateMsgArray = array("idlistener" => $idlistener, "maxMsgId" => $maxMsgId);   
    if (isset($_SESSION['lastPrivateMsgId']) < $privateMsgArray) {
        $_SESSION['lastPrivateMsgId'] = $privateMsgArray;
        showPrivateChatmessages($data);
    } else {
        //Mark Messages as Read when listener loads up the page
        $chatDao->markAsRead($idlistener, $idspeaker);
    }
}*/
?>