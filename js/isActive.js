function isActive()
{
    if ($('#chatArea').length) {
        $.post("functions/isActive.php").done(function(data) {
            console.log(data);
            if (JSON.stringify(data.result) == 'true') {
                alert("You have been inactive for 10 minutes, you have be automatically disconnected from chatroom");
                window.location = 'index.php';
            }
        });
    }
}
setInterval('isActive()', 5000);



