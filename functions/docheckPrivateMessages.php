<?php

session_start();
require_once '../dao/channelDao.php';
include_once '../dao/userDao.php';
include_once '../model/User.php';
include_once '../model/RegisteredUser.php';

$user = new RegisteredUser();

$currentUserId = $_SESSION['sessionid'];
$user->setUserId($currentUserId);
$currentUserIdObj = $user->getUserId();

$channeldao = new ChannelDao();
//TODO:Open Popup is user has pm
$privatechatId = $channeldao->hasPrivateChatCheck($currentUserIdObj);
if ($privatechatId != null) {
   // echo "Private Messages : ";
    foreach ($privatechatId as $user_row) {
        if ($user_row["userid_speaker"] != $_SESSION['sessionid']) { //This prevents from showing self as a private message
            echo "<a class='pmNotification' href='private.php?id=" . $user_row["userid_speaker"] . "'TARGET=_blank'>" . ' ' . $user_row["username"] . "</a>\t";
        }
    }
}
?>
