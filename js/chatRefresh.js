//Fetching new elements using Server-Side Events - Not compatible with Internet Explorer
/*if (typeof (EventSource) !== "undefined")
 {
 var source = new EventSource("functions/doShowMessage.php");
 /* source.onmessage = function(event)
 {
 $("#chatArea").append($("<div>").fadeOut(500).fadeIn(500).append(event.data).emoticonize({}));
 $("#chatArea").scrollTop($("<div>")[0].scrollHeight);
 };
 source.onerror = function(e) {
 //alert("EventSource failed.");
 };
 
 source.addEventListener('message', function(event) {
 $("#chatArea").append($("<div>").fadeOut(500).fadeIn(500).append(event.data).append(event.lastEventId).emoticonize({}));
 console.log(event.data);
 }, false);
 
 source.addEventListener('open', function(event) {
 // Connection was opened.
 }, false);
 
 source.addEventListener('error', function(event) {
 if (event.readyState == EventSource.CLOSED) {
 // Connection was closed.
 }
 }, false);
 }
 else
 {
 document.getElementById("chatArea").innerHTML = "Sorry, your browser does not support server-sent events...";
 
 
 }
 */

//For compatibility with Internet-Explorer but emoticonize has problem

function chatRefresh()
{
    if ($('#chatArea').length) { //check if div exists before fetching data 
        $.post("functions/doShowMessage.php", function(data) {
            $('#chatArea').append($("<div>").fadeOut(150).fadeIn(150).append(data).emoticonize({}));
            //Auto-scroll div
            $('#chatBody').animate({scrollTop: $('#chatArea').prop("scrollHeight")}, 500);
        });
    }
}
setInterval(function() {
    chatRefresh();
}, 1000);



//Post New Messages with Ajax in order not to refresh page and reset messages
$('#chatForm').ajaxForm({
    beforeSubmit:  function() {
       $('#chatForm').clearForm();    //Reset form beforeajax call starts
    },
    success: function(data){
    }
});




