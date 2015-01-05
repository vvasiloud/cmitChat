<?php

if (!isset($_SESSION['sessionid'])) {
    session_start();
}
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require_once '../dao/channelDao.php';
require_once '../dao/userDao.php';
require_once '../model/RegisteredUser.php';


function checkOnlineUsers() {
    $channeldao = new ChannelDao();
    $userdao = new UserDao();
    $user = new RegisteredUser();

    $usersOnline = $channeldao->checkOnline();
    foreach ($usersOnline as $user_row) {
        $gravatarImg = $user->getGravatar($user_row["email"], 35);

        if ($user_row["id"] == $_SESSION['sessionid']) {
            // echo "data:<img class='gravatar' src='$gravatarImg'/>" . ' ' . $user_row["username"]."<br/>"."\n\n";
            echo "<img class='gravatar' src='$gravatarImg'/>" . ' ' . $user_row["username"] . "<br/>";
        } else {
            // echo "data:<img class='gravatar' src='$gravatarImg'/><a href='private.php?id=" . $user_row["id"] . "'TARGET=_blank'>" . ' ' . $user_row["username"] . "</a><br/>"."\n\n";
            echo "<img class='gravatar' src='$gravatarImg'/><a href='private.php?id=" . $user_row["id"] . "'TARGET=_blank'>" . ' ' . $user_row["username"] . "</a><br/>";
        }
    }
    // return $usersOnline;
}

checkOnlineUsers();
?>
