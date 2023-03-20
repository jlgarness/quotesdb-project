<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object 
    $name = new Author($db);

    // Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Retrieve
    if (!isset($data->author)) { 
        // if author is not available
        echo json_encode(array('message' => 'Missing Required Parameters')); 
    } else {
        $name->author = $data->author;
        $name->create();
        echo json_encode(array('id'=> $db->lastInsertId(),'author'=>$name->author));
    }

    
    



