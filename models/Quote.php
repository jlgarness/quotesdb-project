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

            // Create query depending on available data

            // Query if author and category are available
            if (isset($this->author_id) && isset($this->category_id)){
                $query = 
                    'SELECT 
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category,
                        c.id as category_id,
                        a.id as author_id
                    FROM 
                        ' . $this->table . ' q
                    INNER JOIN 
                        authors a on q.author_id = a.id
                    INNER JOIN 
                        categories c on q.category_id = c.id
                    WHERE
                        a.id = :author_id
                    AND
                        c.id = :category_id';
            }

             // Query if only author is available
             else if (isset($this->author_id)){
                $query = 
                    'SELECT 
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category,
                    FROM 
                        ' . $this->table . ' q
                    INNER JOIN 
                        authors a on q.author_id = a.id
                    INNER JOIN 
                        categories c on q.category_id = c.id
                    WHERE
                        a.id = :author_id
                    ';
             }

            // Query if only category is available
            else if (isset($this->category_id)){
                $query = 
                    'SELECT 
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category,
                    FROM 
                        ' . $this->table . ' q
                    INNER JOIN 
                        authors a on q.author_id = a.id
                    INNER JOIN 
                        categories c on q.category_id = c.id
                    WHERE
                        c.id = :category_id
                    ';
            }

            else {
                $query = 
                    'SELECT 
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category,
                    FROM 
                        ' . $this->table . ' q
                    INNER JOIN 
                        authors a on q.author_id = a.id
                    INNER JOIN 
                        categories c on q.category_id = c.id
                    ORDER BY
                        q.id ASC
                    ';
            }

            


        // Prepare statement 
        $stmt = $this->conn->prepare($query);

        // Set bind parameters
        if($this->author_id) $stmt->bindParam(':author_id', $this->author_id);
        if($this->category_id) $stmt->bindParam(':category_id', $this->category_id);

        // Execute query
        $stmt->execute();
        return $stmt;
        }




        // ***READ SINGLE QUOTE***
        public function read_single(){
            // Create query
            $query = 
                'SELECT
                    q.id, 
                    q.quote,
                    a.author as author,
                    c.category as category               
                FROM ' . $this->table . ' q
                INNER JOIN 
                    authors a on q.author_id = a.id
                INNER JOIN 
                    categories c on q.category_id = c.id 
                WHERE 
                    q.id = :id
                LIMIT 1 OFFSET 0'
            ;

            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind parameters
            $stmt->bindParam(':id', $this->id);
            // Execute query
            $stmt->execute();
            // Pull row data
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row){
            // Set the properties 
            $this->quote = $row['quote'];
            $this->id = $row['id'];
            $this->author = $row['author'];
            $this->category = $row['category'];
            return true;
            } else {
                return false;
            }
        }



        // ***CREATE QUOTE***
        public function create(){

            // Create query
            $query = 
                'INSERT INTO 
                    ' . $this->table . ' (quote, author_id, category_id) 
                VALUES(
                :quote,:author_id,:category_id)
                ';


            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind the data to attach to colon parameters above
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
                'UPDATE 
                    ' . $this->table . '
                    SET
                        id = :id,
                        quote = :quote,
                        author_id = :author_id,
                        category_id = :category_id
                    WHERE
                        id = :id
                ';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data to make sure no special characters and to strip tags
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind the data to attach to colon parameters above
            $stmt->bindParam(':quote',$this->quote);
            $stmt->bindParam(':author_id',$this->author_id);
            $stmt->bindParam(':category_id',$this->category_id);
            $stmt->bindParam(':id',$this->id);

            // Execute query
            if ($stmt->execute()){
                if ($stmt->rowCount()==0){
                    return false;
                    } else {
                    return true;
                    }
            } else {
                // Print error if something goes wrong
                 printf("Error: %s.\n", $stmt->error);
            }

        }




        // ***DELETE QUOTE***
        public function delete(){
            // Create query only for id
            $query = 
                    'DELETE FROM 
                        ' . $this->table . '
                    WHERE id= :id
                    ';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean id data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind the id
            $stmt->bindParam(':id',$this->id);

            // Execute query
            if ($stmt->execute()){
                if ($stmt->rowCount()==0){
                    return false;
                    } else {
                    return true;
                    }
            } else {
                // Print error if something goes wrong
                 printf("Error: %s.\n", $stmt->error);
            }

        }
    }