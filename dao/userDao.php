<?php

require_once 'connectdb.php';

class UserDao {

    public function userRegister($username, $password, $email) {
        $password = sha1($password);
        $con = connectToDb::getInstance();
        //$con = new connecttodb();
        //$openCon = $con->connect();

        $query = $con->prepare("INSERT INTO `users` (`username`, `password`, `email`) VALUES (?, ?, ?)");

        $query->bindValue(1, $username);
        $query->bindValue(2, $password);
        $query->bindValue(3, $email);

        try {
            $query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //TODO:Split function to separated functions with each query
    //updateLoginTimestamp
    //updateActiveTime
    //sendGreet
    public function userLogin($username, $password) {

        //$con = new connecttodb();
        $con = connectToDb::getInstance();
        //$openCon = $con->connect();

        $password = sha1($password);

        $query = $con->prepare("SELECT `id` FROM `users` WHERE `username` = ? AND `password` = ? ");
        $query->bindValue(1, $username);
        $query->bindValue(2, $password);

        try {
            $query->execute();
            $data = $query->fetch();
            $id = $data['id'];


            if ($id == null) { //Catch error if id is not in the database
                return $id;
            } else {
                //Update Timestamp field on DB with the current one
                $updateUserStatusQuery = $con->prepare("UPDATE `users` SET `timestamp` = NOW() WHERE `id` = ?");
                $updateUserStatusQuery->bindValue(1, $id);

                try {
                    $updateUserStatusQuery->execute();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
                //Update Time filed on DB that corresponds to the Time as Int
                $time = time();
                $updateUserActivityQuery = $con->prepare("UPDATE `users` SET `lastactive` = ? WHERE `id` = ?");
                $updateUserActivityQuery->bindValue(1, $time);
                $updateUserActivityQuery->bindValue(2, $id);


                try {
                    $updateUserActivityQuery->execute();
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                //Send Message to Public_Chat
                $welcometext = ' ' . 'has entered the chatroom';
                $notifyChatroom = $con->prepare("INSERT INTO `public_chat`(`chat_text`, `user_id` ) VALUES (?, ?)");

                $notifyChatroom->bindValue(1, $welcometext);
                $notifyChatroom->bindValue(2, $id);

                try {
                    $notifyChatroom->execute();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }

            return $id;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //TODO:Split function to separated functions with each query
    //updateActiveTime
    //sendGoodbye
    public function userLogout($userid) {

        $con = connectToDb::getInstance();
        //$con = new connecttodb();
        //$openCon = $con->connect();

        //Update Time field on DB that corresponds to the Time as Int
        $time = 0;
        $query = $con->prepare("UPDATE `users` SET `lastactive` = ? WHERE `id` = ?");
        $query->bindValue(1, $time);
        $query->bindValue(2, $userid);

        try {
            $query->execute();

            //Send Logout Message to Public_Chat
            $logouttext = ' ' . 'has left the chatroom';
            $notifyChatroom = $con->prepare("INSERT INTO `public_chat`(`chat_text`, `user_id` ) VALUES (?, ?)");

            $notifyChatroom->bindValue(1, $logouttext);
            $notifyChatroom->bindValue(2, $userid);

            try {
                $notifyChatroom->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function isActive($sessionid) {

        $con = connectToDb::getInstance();
        //$openCon = $con->connect();

        $time = time() - 600; //if remain inactive for 10 Minute 

        $isActiveQuery = $con->prepare("SELECT `id`= ? FROM `users` WHERE `lastactive` > ?");
        $isActiveQuery->bindValue(1, $sessionid);
        $isActiveQuery->bindValue(2, $time);
        try {
            $isActiveQuery->execute();
            $result = $isActiveQuery->fetchAll();
            if ($result != NULL) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function userExists($username) {
        $con = connectToDb::getInstance();
        //$openCon = $con->connect();

        $query = $con->prepare("SELECT COUNT(`users`.`username`) FROM `users` WHERE `users`.`username` = ?");
        $query->bindValue(1, $username);

        try {
            $query->execute();
            $rows = $query->fetchColumn();

            if ($rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function emailExists($email) {
        $con = connectToDb::getInstance();
       // $openCon = $con->connect();

        $query = $con->prepare("SELECT COUNT(`users`.`email`) FROM `users` WHERE `users`.`email` = ?");
        $query->bindValue(1, $email);

        try {

            $query->execute();
            $rows = $query->fetchColumn();

            if ($rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}

?>