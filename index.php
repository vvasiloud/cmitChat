<?php
session_start();
    if(!isset($_SESSION[ 'sessionid' ] )) 
    { 
        session_start();
        header('Location:login.php');

    }
else
{
        session_start();
        
        header('Location:chat.php');
    } 
    header( 'Content-Type: text/html; charset=utf-8' );
 
?>