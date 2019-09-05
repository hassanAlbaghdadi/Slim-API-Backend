<?php
    class db{
        //properties
        private $dbhost="localhost";
        private $dbuser="root";
        private $dbpass="";
        private $dbname="bluedrop";

        //connecting to db
        public function connect(){
            $mysql_connect_str= "mysql:host=$this->dbhost; dbname=$this->dbname";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            
            //error reporting
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $dbConnection;
        }
    }