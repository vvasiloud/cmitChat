<?php

include_once 'User.php';

class RegisteredUser extends User {

    protected $password;
    protected $gerne;

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getGerne() {
        return $this->gerne;
    }

    public function setGerne($gerne) {
        $this->gerne = $gerne;
    }




}

?>
