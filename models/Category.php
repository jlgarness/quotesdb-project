<?php

/* Creating class for Category*/

    class Category{
        // DB stuff
        private $conn;
        private $table = 'categories';

        // Post Properties
        public $id, $category;
        
    
        // Constructor with DB (runs automatically when instantiating class or class object)
        public function __construct($db){
            $this->conn = $db;
        }




        // ***READ ALL CATEGORIES***
        public function read(){

            // Create query
            $query = 
                'SELECT 
                    id,
                    category
                
                FROM 
                    ' . $this->table . ' 
                ORDERED BY id ASC
                ';

        // Prepare statement 
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();
        return $stmt;
        }




        // ***READ SINGLE CATEGORY***
        public function read_single(){
            // Create query
            $query = 
                'SELECT 
                    category,
                    id 
                FROM 
                    ' . $this->table . ' 
                WHERE
                    id = :id
                LIMIT 1 OFFSET 0';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind the id to the question mark
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row)
            {
                // Set the properties 
                $this->category = $row['category'];
                $this->id = $row['id'];
                return true;
            } else {
                return false;
            }
        }



        // ***CREATE CATEGORY***
        public function create(){

            // Create query
            $query = 
                'INSERT INTO ' . $this->table . '
                    SET
                        id = :id,
                        category = :category
                ';
                        
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));
           
            // Bind the data to attach to colon parameters above
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':category',$this->category);

            // Execute query
            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;
        }



        // ***UPDATE CATEGORY***
        public function update(){

            // Create query
            $query = 
                'UPDATE ' . $this->table . '
                    SET
                        category = :category

                    WHERE
                        id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));
           
            // Bind the data to attach to colon parameters above
            $stmt->bindParam(':category',$this->category);
           
            // Execute query
            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;

        }




        // ***DELETE CATEGORY***
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
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;


        }

    }