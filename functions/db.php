<?php
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_NAME','dbuser0');

    class Database {
        private $connection;
    
        public function __construct() {
            try{
                $this->connection = new mysqli(DB_HOST, DB_USER ,DB_PASS ,DB_NAME);
            }catch(Exception $e){
                die('Unable to connect to Database');
            }
        }
        
        public function getConnection() : object{
            return  $this->connection;
        }
        
        function __destruct(){
            mysqli_close($this->connection);
        }
    }