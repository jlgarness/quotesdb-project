<?php

/* Creating class for Author*/

    class Author{

        // DB stuff
        private $conn;
        private $table = 'authors';
       

        // Post Properties
        private $id, $author;

    
        // Constructor with DB (runs automatically when instantiating class or class object)
        public function __construct($db){
            $this->conn = $db;
        }

        // Getters and Setters
         public function get_id() {
            return $this->id;
        }

        public function set_id($id) {
            $this->id = htmlspecialchars(strip_tags($id));
        }

        public function get_author() {
            return $this->author;
        }

        public function set_author($author) {
            $this->author = htmlspecialchars(strip_tags($author));
        }





        // ***READ ALL AUTHORS***
        public function read(){

            // Create query
            $query = 
                'SELECT 
                    a.author,
                    a.id 
                FROM 
                    ' . $this->table . ' a
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
                    a.author,
                    a.id 
                FROM 
                    ' . $this->table . ' a
                WHERE
                    a.id = ?
                LIMIT 0,1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind the id to the question mark
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set the properties 
            $this->author = $row['author'];
        }



        // ***CREATE AUTHOR***
        public function create(){

            // Create query
            $query = 
                'INSERT INTO ' . $this->table . ' a
                    SET
                        a.id = :id,
                        a.author = :author
                ';
                        
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));
           
            // Bind the data to attach to colon parameters above
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
                'UPDATE ' . $this->table . ' a
                    SET
                       a.author = :author

                    WHERE
                        a.id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->author = htmlspecialchars(strip_tags($this->author));
           
            // Bind the data to attach to colon parameters above
            $stmt->bindParam(':author',$this->author);
           
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
            $query = 'DELETE FROM ' . $this->table . ' WHERE a.id= :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean id data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind the id
            $stmt->bindParam(':id',$this->id);

            // Execute query
            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;


        }

    }