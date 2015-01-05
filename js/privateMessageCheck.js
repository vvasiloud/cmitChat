function privateMessageCheck()
{
    //Update Online Users
    if ($('#pmcheck').length) {
        $("#pmcheck").load("functions/docheckPrivateMessages.php");
    }
}
setInterval('privateMessageCheck()', 5000);
/*$(function(){
 
 $.longpollingPrivate({
 pollURL: '../functions/docheckPrivateMessages.php',
 successFunction: pollSuccessPrivate,
 errorFunction: pollErrorPrivate
 });
 
 });
 
 function pollSuccessPrivate(data, textStatus, jqXHR){
 var json = eval('(' + data + ')');
 $('#chatArea').html(json['data']);
 }
 
 function pollErrorPrivate(jqXHR, textStatus, errorThrown){
 console.log('Long Polling Error: ' + textStatus);
 }*/
