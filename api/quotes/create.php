<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Category.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote objects 
    $body = new Quote($db);
    $name = new Author($db);
    $cat = new Category($db);

    // Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Retrieve
    if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)){
        // if author is not available
        echo json_encode(array('message' => 'Missing Required Parameters')); 
        exit();
    } 

    // Set properties
    $body->quote = $data->quote;
    $body->author_id = $data->author_id;
    $body->category_id = $data->category_id;
    $name->id = $data->author_id;
    $cat->id = $data->category_id;

    // Checks
    $name->read_single();
    $cat->read_single();

        // If checks fail and author or category are not available
        if (!$name->author){
            echo json_encode(array('message'=>'author_id Not Found'));
        } 
        
        else if (!$cat->category){
                echo json_encode(array('message' => 'category_id Not Found'));
        }

        // Proceed to create
        else if ($body->create()){
            echo json_encode(array('id'=> $db->lastInsertId(),'quote'=> $body->quote, 'author_id'=>$body->author_id, 'category_id'=>$body->category_id));

        }

        // Error message for other failures
        else {
            echo json_encode(array('message'=>'Quote Not Added'));
        }
        

        
    