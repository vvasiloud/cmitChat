<?php

require_once '../dao/userDao.php';
require_once '../model/User.php';
require_once '../model/RegisteredUser.php';


$dao = new UserDao();
$obj = new RegisteredUser();
$obj->setUsername($_POST['username']);
$obj->setPassword($_POST['password']); 
$obj->setEmail($_POST['email']);
//TODO:genre,picture

$dao->userRegister($obj->getUsername(), $obj->getPassword(), $obj->getEmail());

/*$usercheck=$dao->userExists($obj->getUsername());
$emailcheck=$dao->emailExists($obj->getEmail());
if ($usercheck==0 && $emailcheck==0)
{
       $dao->userRegister($obj->getUsername(), $obj->getPassword(), $obj->getEmail());
        header('Location: ../index.php');
}
else if ($usercheck==1 && $emailcheck==1)
{
        echo '<script>alert( "Both Username and Email Exists") </script>';
}
else if ($usercheck==1)
{
        echo '<script>alert( "Username Exists") </script>';
}
else
{
        echo '<script>alert( "Email Exists") </script>';
}
*/

header('Location: ../index.php');
?>
