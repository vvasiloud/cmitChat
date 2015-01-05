//Split url and isolate GET
var parts = window.location.search.substr(1).split("&");
var $_GET = {};
for (var i = 0; i < parts.length; i++) {
    var temp = parts[i].split("=");
    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
}

function chatRefreshPrivate(userid)
{
    var string_url = "functions/doShowMessagePrivate.php?id=" + userid;
    if ($('#chatPrivateBody').length) { //check if div exists before fetching data 
        $.post(string_url, function(data) {
            $('#chatroom-' + userid).find('#chatPrivateBody').append($("<div>").fadeOut(150).fadeIn(150).append(data).emoticonize({}));
            //Auto-scroll div
            $('#chatroom-' + userid).find('#chatPrivateBody').animate({scrollTop: $('#chatPrivateBody').prop("scrollHeight")}, 500);
        });
    }
}
setInterval(function() {
    chatRefreshPrivate($_GET['id']);
}, 3000);

//Post New Messages with Ajax in order not to refresh page and reset messages
$('#chatFormPrivate').ajaxForm({
    beforeSubmit:  function() {
       $('#chatFormPrivate').clearForm();    //Reset form beforeajax call starts
    },
    success: function(data){
    }
});
