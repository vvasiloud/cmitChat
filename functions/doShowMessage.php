<?php

if (!isset($_SESSION['sessionid'])) {
    session_start();
}
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require_once '../dao/channelDao.php';
require_once '../model/Channel.php';
require_once '../model/PublicChannel.php';

function getPublicChatMessages($lastMsgId) {
    $chatDao = new ChannelDao();
    $chatMessages = $chatDao->channelRecievePublic($lastMsgId);
    // echo "data: $serverTime \n\n";
    return $chatMessages;
}

//Populate an array of Channel Objects from the query
function showPublicChatmessages($chatMessages) {

    if ($chatMessages != NULL) {
        foreach ($chatMessages as $row) {
            $channel = new PublicChannel();
            $channel->setUserid($row['username']);
            $channel->setChatText($row['chat_text']);
            $channel->setTimestamp($row['timestamp']);
            $channel->setUserImg($row['email']);


            $channelMessages[] = $channel;
        }
        //Show the list
        foreach ($channelMessages as $obj) {
            $timestamp = $obj->getTimestamp();
            $username = $obj->getUserid();
            $chattext = htmlentities($obj->getChatText()); //prevent html injection
            $userimg = $obj->getUserImg();
            $gravatarImg = $obj->getGravatar($userimg, 25);
            //TODO: Debug only - Remove later
            //$counter=rand();
            //echo "id: $counter\n";
            //echo "data: <div class='chatMessage'> $timestamp &nbsp <img class='gravatarOnchat' src='$gravatarImg'/> $username: &nbsp  $chattext<br></div> \n\n";
            echo "<div class='chatMessage'> $timestamp &nbsp <img class='gravatarOnchat' src='$gravatarImg'/> $username: &nbsp  $chattext<br></div> ";
            //ob_flush();
            //flush();
        }
    } else {
        //echo "data:null \n\n";
        //sleep(3);
    }
}

//$date = date_create();
//date_sub($date, date_interval_create_from_date_string('1 second'));
//$serverTime = date_format($date, 'Y-m-d H:i:s');
//echo $serverTime;

//Get last message Id
$chatDao = new ChannelDao();
$lastMsg = $chatDao->getLastMsgId();
foreach ($lastMsg as $row) {
    $lastMsgId = $row['maxId'];
}

//Get current message count
$currentMsgCount = $chatDao->countMessages();
foreach ($currentMsgCount as $row) {
    $currMsgCount = $row['msgCount'];
}

//Calculate differenced between previous count and current count
//to find how many messages haven't been shown
$baseCount = $_SESSION['msgCount'];
$difference = $currMsgCount - $baseCount;

if ($difference != 0) {
    $lastMsgId = $lastMsgId-  $difference;
        $_SESSION['msgCount'] = $currMsgCount;
        $data = getPublicChatMessages($lastMsgId);
        showPublicChatmessages($data);
}
//dublicate messages check
/* if ($data != NULL) {
  foreach ($data as $row) {
  $maxMsgId = $row['id'];
  $lastMsgTimestamp = $row['timestamp'];
  //echo "MaxMsgID:" . $maxMsgId;
  //echo '.\t';
  //echo "serverTime:" . $serverTime;
  //echo "lastMsgTime:" . $lastMsgTimestamp;
  }
  if (isset($_SESSION['lastMsgId']) < $maxMsgId) {
  $_SESSION['lastMsgId'] = $maxMsgId;
  showPublicChatmessages($data);
  }

  } */
?>
