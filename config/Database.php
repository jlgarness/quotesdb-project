<?php
    class Database {
        // DB Params
        private $host;
        private $db_name;
        private $username;
        private $password;
        private $conn;
        private $port;


        public function __construct(){
            $this->username = 'postgres';
            $this->password = '2461';
            $this->db_name = 'quotesdb';
            $this->host = 'dpg-cgcvdse4dad6fr7q1nfg-a';
            $this->port = '5432';
        }


        /* Retrieve env variable data to hide info
        public function __construct(){
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->db_name = getenv('DBNAME');
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
        }
        */
        
        // DB Connect
        public function connect(){
            $this->conn = null;

            try {
                $this->conn = new PDO('pgsql:host=' . $this->host . ';dbname=' . $this->db_name . ';port=' . $this->port,
                $this->username, $this->password);   
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
            }  
            // Connection error message 
            catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
            }
            return $this->conn;
        }

    }