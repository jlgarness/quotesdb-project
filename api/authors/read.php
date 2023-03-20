<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object 
    $author = new Author($db);

    // Blog post query
    $result = $author->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any posts exist
    if($num>0) {
        //Post array
        $authors_arr = array();
        $authors_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $author_item = array(
                'id' => $id,
                'author'=> $author,
    
            );

            // Push to "data" array
            array_push($authors_arr['data'], $author_item);
        }

        // Convert to JSON & output
        echo json_encode($authors_arr);
    } else {
        // No Posts
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }