<?php

/* Creating class for Quotes*/

    class Quote{
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // Post Properties
        public $id;
        public $quote;
        public $category_id;
        public $author_id;
        public $category;
        public $author;
       

        // Constructor with DB (runs automatically when instantiating class or class object)
        public function __construct($db){
            $this->conn = $db;
        }




        // ***READ ALL QUOTES***
        public function read(){
            // Create query
            $query = 
                'SELECT 
                    q.id,
                    q.quote,
                    a.author,
                    c.category,
                    c.id as category_id,
                    a.id as author_id
                FROM 
                    ' . $this->table . ' 
                ';
        // Prepare statement 
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();
        return $stmt;
        }




        // ***READ SINGLE QUOTE***
        public function read_single(){
            // Create query
            $query = 
                'SELECT 
                    quote 
                FROM 
                    ' . $this->table . ' 
                WHERE
                    p.id = ?
                LIMIT 0,1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind the id to the question mark
            $stmt->bindParam(1, $this->id);
            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Set the properties 
            $this->quote = $row['quote'];
        }



        // ***CREATE QUOTE***
        public function create(){

            // Create query
            $query = 
                'INSERT INTO ' . $this->table . '
                    SET
                        id = :id,
                        quote = :quote,
                        author = :author,
                        category = :category,
                        author_id = :author_id,
                        category_id = :category_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind the data to attach to colon parameters above
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':quote',$this->quote);
            $stmt->bindParam(':quote',$this->author);
            $stmt->bindParam(':quote',$this->category);
            $stmt->bindParam(':author_id',$this->author_id);
            $stmt->bindParam(':category_id',$this->category_id);

            // Execute query
            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;


        }



        // ***UPDATE QUOTE***
        public function update(){

            // Create query
            $query = 
                'UPDATE ' . $this->table . '
                    SET
                        quote = :quote,
                        author = :author,
                        category = :category,
                        author_id = :author_id,
                        category_id = :category_id
                    WHERE
                        id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind the data to attach to colon parameters above
            $stmt->bindParam(':quote',$this->quote);
            $stmt->bindParam(':author',$this->author);
            $stmt->bindParam(':category',$this->category);
            $stmt->bindParam(':author_id',$this->author_id);
            $stmt->bindParam(':category_id',$this->category_id);
            $stmt->bindParam(':id',$this->id);

            // Execute query
            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;

        }




        // ***DELETE QUOTE***
        public function delete(){
            // Create query only for id
            $query = 'DELETE FROM ' . $this->table . ' WHERE id= :id';

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