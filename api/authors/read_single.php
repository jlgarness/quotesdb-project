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

    // Get the id from the URL
    $name->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call method 
    if($name->read_single()) {
        // Author available
        echo json_encode(array('id' => $name->id,'author' => $name->author));
       } else {
        // Author not found
       echo json_encode(array('message' => 'author_id Not Found'));
     }
   