function userRefresh()
{
    //Update Online Users
    if ($('#onlineUsers').length) {
        $("#onlineUsers").load("functions/docheckOnlineUsers.php");
    }
}
setInterval('userRefresh()', 5000);

