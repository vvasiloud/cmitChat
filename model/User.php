<?php

abstract class User 
{
    protected $userid;
    protected $username; 
    protected $email;
     
    public function getUserId() {
        return $this->userid;
    }

    public function setUserId($userid) {
        $this->userid = $userid;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getGravatar($email,$gravatarImgSize) {
        $gravatarBase = "http://www.gravatar.com/avatar/";
        $gravatarHash = md5(strtolower(trim($email)));
        $gravatarSizePrefix = "?s="; 
        $gravatarUserImg = $gravatarBase . $gravatarHash .$gravatarSizePrefix. $gravatarImgSize;
        return $gravatarUserImg;
    }
}

?>
