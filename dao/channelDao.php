<?php

require_once 'connectdb.php';

class ChannelDao {

    //TODO:Split function to separated functions with each query
    //add userUpdatePresence($userid)
    public function channelSendPublic($chattext, $userid) {

        //$con = new connecttodb();
        $con = connectToDb::getInstance();
        //$openCon = $con->connect();

        $query = $con->prepare("INSERT INTO `public_chat`(`chat_text`, `user_id` ) VALUES (?, ?)");

        $query->bindValue(1, $chattext);
        $query->bindValue(2, $userid);

        try {
            $query->execute();

            //Update Time field on DB that corresponds to the Time as Int
            $time = time();
            $updateUserActivityQuery = $con->prepare("UPDATE `users` SET `lastactive` = ? WHERE `id` = ?");
            $updateUserActivityQuery->bindValue(1, $time);
            $updateUserActivityQuery->bindValue(2, $userid);

            try {
                $updateUserActivityQuery->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getLastMsgId() {
        
        $con = connectToDb::getInstance();
        $query = $con->prepare("SELECT MAX(`public_chat`.`id`) as maxId FROM `public_chat`");
        try {
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
     public function countMessages() {
          $con = connectToDb::getInstance();
        $query = $con->prepare("SELECT COUNT(`public_chat`.`id`) as msgCount FROM `public_chat`");
        try {
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
     }
     
         public function getLastMsgIdPrivate($userid_speaker, $userid_listener) {
        
        $con = connectToDb::getInstance();
        $query = $con->prepare("SELECT MAX(`private_chat`.`id`) as maxId FROM `private_chat` WHERE ((`private_chat`.`userid_speaker` = ? AND `private_chat`.`userid_listener` = ?) OR (`private_chat`.`userid_speaker` =? AND `private_chat`.`userid_listener` = ?))");
        $query->bindValue(1, $userid_speaker);
        $query->bindValue(2, $userid_listener);
        $query->bindValue(3, $userid_listener);
        $query->bindValue(4, $userid_speaker);
        try {
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
     public function countPrivateMessages($userid_speaker, $userid_listener) {
        $con = connectToDb::getInstance();
        $query = $con->prepare("SELECT COUNT(`private_chat`.`id`) as msgCount FROM `private_chat` WHERE ((`private_chat`.`userid_speaker` = ? AND `private_chat`.`userid_listener` = ?) OR (`private_chat`.`userid_speaker` =? AND `private_chat`.`userid_listener` = ?))");
        $query->bindValue(1, $userid_speaker);
        $query->bindValue(2, $userid_listener);
        $query->bindValue(3, $userid_listener);
        $query->bindValue(4, $userid_speaker);
        try {
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
     }

    public function channelRecievePublic($id) {

        $con = connectToDb::getInstance();
        //$con = new connecttodb();
        //$openCon = $con->connect();
        //TODO:display messages only after the login
        //select where timestamp older that login timestamp
        $query = $con->prepare("SELECT `public_chat`.`id`,`public_chat`.`chat_text`,`public_chat`.`timestamp`,`users`.`username`,`users`.`email` FROM `public_chat`,`users` WHERE `users`.`id` = `public_chat`.`user_id` AND `public_chat`.`id` > ? ORDER BY `public_chat`.`timestamp` ASC  ");
        $query->bindValue(1, $id);
        try {
            $query->execute();

            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //TODO:Split function to separated functions with each query
    public function channelSendPrivate($chattext, $userid_speaker, $userid_listener) {

        $con = connectToDb::getInstance();
        // $con = new connecttodb();
        //$openCon = $con->connect();

        $query = $con->prepare("INSERT INTO `private_chat`(`chat_text`, `userid_speaker`,`userid_listener` ) VALUES (?, ? , ?)");

        $query->bindValue(1, $chattext);
        $query->bindValue(2, $userid_speaker);
        $query->bindValue(3, $userid_listener);

        try {
            $query->execute();

            //Update Time field on DB that corresponds to the Time as Int
            $time = time();
            $updateUserActivityQuery = $con->prepare("UPDATE `users` SET `lastactive` = ? WHERE `id` = ?");
            $updateUserActivityQuery->bindValue(1, $time);
            $updateUserActivityQuery->bindValue(2, $userid_speaker);
            try {
                $updateUserActivityQuery->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //TODO:display messages only after the last chat
    //pick last chatted message and show messages only AFTER that
    //Split function into two separate
    public function channelRecievePrivate($timestamp, $userid_speaker, $userid_listener) {

        $con = connectToDb::getInstance();
        //$con = new connecttodb();
        //$openCon = $con->connect();

        $query = $con->prepare("SELECT `private_chat`.`id`,`private_chat`.`chat_text`,`private_chat`.`timestamp`,(SELECT `users`.`username` FROM `users` WHERE `private_chat`.`userid_speaker`= `users`.`id`) as usernameSpeaker,(SELECT `users`.`email` FROM `users` WHERE `private_chat`.`userid_speaker` = `users`.`id`) as emailSpeaker FROM `private_chat` WHERE `private_chat`.`timestamp` >= ? AND ((`private_chat`.`userid_speaker` = ? AND `private_chat`.`userid_listener` = ?) OR (`private_chat`.`userid_speaker` =? AND `private_chat`.`userid_listener` = ?))");
        $query->bindValue(1, $timestamp);
        $query->bindValue(2, $userid_speaker);
        $query->bindValue(3, $userid_listener);
        $query->bindValue(4, $userid_listener);
        $query->bindValue(5, $userid_speaker);
        try {
            $query->execute();
            $result = $query->fetchAll();

            if ($result == NULL) { //fetch unread messages
                $queryUnreadMsg = $con->prepare("SELECT `private_chat`.`id`,`private_chat`.`chat_text`,`private_chat`.`timestamp`,(SELECT `users`.`username` FROM `users` WHERE `private_chat`.`userid_speaker`= `users`.`id`) as usernameSpeaker,(SELECT `users`.`email` FROM `users` WHERE `private_chat`.`userid_speaker` = `users`.`id`) as emailSpeaker FROM `private_chat` WHERE (`private_chat`.`hasReadListener` = 'N' AND `private_chat`.userid_listener = ?) AND ((`private_chat`.`userid_speaker` = ? AND `private_chat`.`userid_listener` = ?) OR (`private_chat`.`userid_speaker` =? AND `private_chat`.`userid_listener` = ?))");
                $queryUnreadMsg->bindValue(1, $userid_speaker);
                $queryUnreadMsg->bindValue(2, $userid_speaker);
                $queryUnreadMsg->bindValue(3, $userid_listener);
                $queryUnreadMsg->bindValue(4, $userid_listener);
                $queryUnreadMsg->bindValue(5, $userid_speaker);

                try {
                    $queryUnreadMsg->execute();
                    $result = $queryUnreadMsg->fetchAll();
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }

            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function markAsRead($userid_speaker, $userid_listener) {

        $con = connectToDb::getInstance();
        //$openCon = $con->connect();

        $queryUpdateUnreadMsg = $con->prepare("UPDATE `private_chat` SET `hasReadListener` = 'Y' WHERE `private_chat`.userid_listener = ? AND (`private_chat`.`userid_speaker` = ? AND `private_chat`.`userid_listener` = ?)");
        $queryUpdateUnreadMsg->bindValue(1, $userid_listener);
        $queryUpdateUnreadMsg->bindValue(2, $userid_speaker);
        $queryUpdateUnreadMsg->bindValue(3, $userid_listener);
        try {
            $queryUpdateUnreadMsg->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //TODO:not validated
    public function hasPrivateChatCheck($userid_listener) {
        $con = connectToDb::getInstance();
        //$con = new connecttodb();
        //$openCon = $con->connect();
        //Check for Pm each 1 minute
        $query = $con->prepare("SELECT DISTINCT `private_chat`.`userid_speaker`,(SELECT `users`.`username` FROM users WHERE `private_chat`.`userid_speaker`= `users`.`id`  )as username, (SELECT `users`.`email` FROM users WHERE `private_chat`.`userid_speaker` = `users`.`id` ) as email FROM private_chat WHERE `private_chat`.`userid_listener` = ? AND`private_chat`.`hasReadListener` = 'N'");
        $query->bindValue(1, $userid_listener);
        try {
            $query->execute();
            $result = $query->fetchAll();

            //Return userid_speaker for private messages of the last 1 minute
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //TODO:Remove the magic numbers
    public function checkOnline() {

        $con = connectToDb::getInstance();
        // $con = new connecttodb();
        //$openCon = $con->connect();
        //$sessionid = $_SESSION['sessionid'];
        $time = time() - 600; //if remain inactive for 10 Minute 

        $usersOnlineQuery = $con->prepare("SELECT `id`,`username`,`email` FROM `users` WHERE `lastactive`> ? ORDER BY `username` ASC");
        $usersOnlineQuery->bindValue(1, $time);
        try {
            $usersOnlineQuery->execute();
            $result = $usersOnlineQuery->fetchAll();
            return $result;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
