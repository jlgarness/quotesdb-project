<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object 
    $name = new Author($db);

    // Author query
    $result = $name->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any authors exist
    if($num>0) {
        //Authors array
        $authors_arr = array();

        // Fetch author data
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $author_item = array(
                'id' => $id,
                'author'=> $author,
    
            );

            // Push to array
            array_push($authors_arr, $author_item);
        }

        // Convert to JSON & output
        echo json_encode($authors_arr);
    } else {
        // No authors available
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }