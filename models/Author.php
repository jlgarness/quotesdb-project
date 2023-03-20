<?php

/* Creating class for Author*/

    class Author{

        // DB stuff
        private $conn;
        private $table = 'authors';
       

        // Post Properties
        public $id, $author;

    
        // Constructor with DB (runs automatically when instantiating class or class object)
        public function __construct($db){
            $this->conn = $db;
        }

        // ***READ ALL AUTHORS***
        public function read(){

            // Create query
            $query = 
                'SELECT 
                    author,
                    id 
                FROM 
                    ' . $this->table . ' 
                ORDER BY id ASC
                ';
            

             // Prepare statement 
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();
            return $stmt;
        }




        // ***READ SINGLE AUTHOR***
        public function read_single(){

            // Create query
            $query = 
                'SELECT 
                    id
                    author 
                FROM 
                    ' . $this->table . ' 
                WHERE
                    id = :id
                LIMIT 1 OFFSET 0';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind the id to the question mark
            $stmt->bindParam(':id"', $this->id);

            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row){
            // Set the properties 
            $this->id = $row['id'];
            $this->author = $row['author'];
            return true;
            } else {
                return false;
            }
        }



        // ***CREATE AUTHOR***
        public function create(){

            // Create query
            $query = 
                'INSERT INTO ' . $this->table . ' 
                    SET
                        id = :id,
                        author = :author
                ';
                        
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));
           
            // Bind the data to attach to parameters above
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':author',$this->author);

            // Execute query
            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;
        }



        // ***UPDATE AUTHOR***
        public function update(){

            // Create query
            $query = 
                'UPDATE ' . $this->table . ' 
                    SET
                       author = :author

                    WHERE
                        id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));
           
            // Bind the data to attach to colon parameters above
            $stmt->bindParam(':author',$this->author);
            $stmt->bindParam(':id', $this->id);
           
            // Execute query
            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;

        }


        // ***DELETE AUTHOR***
        public function delete(){

            // Create query only for id
            $query = 
                'DELETE FROM 
                    ' . $this->table . ' 
                WHERE 
                    id= :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean id data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind the id
            $stmt->bindParam(':id',$this->id);

            // Execute query
            if ($stmt->execute()){
                return true;
            } else {

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;
            }

        }

    }