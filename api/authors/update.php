<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object 
    $name = new Author($db);

    // Retrieve
    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->id)|| !isset($data->author)) {
        // Author not available
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    // Set properties
    $name->author = $data->author;
    $name->id = $data->id;
    
    // Proceed with update
    if ($name->update()){
        echo json_encode(array('id'=>$name->id,'author'=>$name->author));
    }
    else
    {
        echo json_encode(array('message' => 'author_id Not Found'));
    }

    
    



