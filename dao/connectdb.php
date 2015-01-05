<?php

class connectToDb {

    protected $config = array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'chatdb'
    );
    protected static $con;
    protected static $instance = NULL;

    //Singleton Pattern
    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new connectToDb();
        }
        return self::$con;
    }

    private function __construct() {
        $config = $this->config;

        self::$con = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone() {
        
    }

    /* public function connect() {
      $config = $this->config;

      $con = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //return $con;
      } */

    //This function will create database if not exists
    public function databaseExists() {
        
    }

    public function close($con) {
        $con = null;
    }

}

?>
