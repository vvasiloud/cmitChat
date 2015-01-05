<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'header.php';
require_once 'dao/channelDao.php';
require_once 'dao/userDao.php';
//include 'functions/isActive.php';
//include './functions/doLogout.php';./functions/doPostMessage.php
//isActive($_SESSION['sessionid']);
?>

<div id='wrapper' name='wrapper' >
    <div name='logout' class='logoutBox'>

        <form id='logoutForm' action='functions/doLogout.php' method='post'>
            <?php
            if (isset($_SESSION['sessionid'])) {
                echo "You are logged in as " . $_SESSION['username'];
            }
            ?>
            <input type='submit' name='logout' class='logoutButton' id='logout' value="Logout"/>
        </form>
        <div id="pmcheck" name="pmcheck"  class='pmcheck' ></div>
    </div>

    <div id='chatBody' name='chatBody' class='chatBody'>
        <div id='chatArea' name='chatArea' class='chatArea'> 
            <script>chatRefresh();</script>
        </div>
    </div>
    <div id='onlineUsersDiv' name='onlineUsersDiv' class='chatOnUser' >
        Online Users:
        <div id='onlineUsers'>
            <script>userRefresh();</script>
        </div>
        <div id='userActiveDiv' name='userActiveDiv' ></div>
    </div> 
    <div name='chatBox' class='chatBox'>
        <form id="chatForm" method="post" action="functions/doPostMessage.php" > <br/>
            <input type='text' name='chatText' id='chatText' class='chatTextBox' autocomplete='off' />
            <input type='submit' name='sendButton' class='sendButton' value='Send' /> <br/>
        </form>
    </div>       
</div>
</div>

<?php
include 'footer.php';
?>