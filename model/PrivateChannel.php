<?php

include_once 'Channel.php';

class PrivateChannel extends Channel {

    protected $userid_listener;

    public function getUseridListener() {
        return $this->userid_listener;
    }

    public function setUseridListener($userid_listener) {
        $this->userid_listener = $userid_listener;
    }

}

?>