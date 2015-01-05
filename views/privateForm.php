<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'header.php';
include_once 'dao/channelDao.php';
//include './functions/doShowMessagePrivate.php';
?>

<div name='wrapper' >
    <div id='chatroom-<?php echo $userid; ?>'> 
        <div id='chatPrivateBody' name='chatPrivateBody' class='chatBody'>
            <script>chatRefreshPrivate(<?php echo $userid; ?>);</script> 
        </div>
    </div>
    <div id='userGravatars' name='userGravatars' class='chatOnUser' >
        <div id='userSpeaker'></div>
        <div id='userListener'></div>
    </div>
    <div name='chatBox' class='chatBox'>
        <form id="chatFormPrivate" method="post" action='functions/doPostMessagePrivate.php?id=<?php echo $userid; ?>'> <br/>
            <input type='text' name='chatText' id='chatText'  class='chatTextBox' autocomplete='off' />
            <input type='submit' name='sendButton' class='sendButton' value='Send' /> 
        </form>
    </div>

</div>

<?php
include 'footer.php';
?>