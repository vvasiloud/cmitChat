<?php

abstract class Channel  {

    protected $userid;
    protected $chattext;
    protected $timestamp;
    protected $userimg;

    public function getUserid() {
        return $this->userid;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function getChatText() {
        return $this->chattext;
    }

    public function setChatText($chattext) {
        $this->chattext = $chattext;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
    
    public function getUserImg() {
        return $this->userimg;
    }

    public function setUserImg($userimg) {
        $this->userimg = $userimg;
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