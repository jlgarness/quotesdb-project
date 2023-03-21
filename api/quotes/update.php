<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Category.php';


    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object 
    $body = new Quote($db);

    // Retrieve
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id)|| !isset($data->author)) {
        // Author not available
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    // Set properties
    $body->id = $data->id;
    $body->quote = $data->quote;
    $body->author_id = $data->author_id;
    $body->category_id = $data->category_id;

    $name = new Author($db);
    $cat = new Category($db);
    $name->id = $body->author_id;
    $cat->id = $body->category_id;

    
    // Run Checks
    $auth->read_single();

    // Check fails, no author_id
    if (!$name->author) {
        echo json_encode(array('message' => 'author_id Not Found'));
        exit();
    }
    

    $cat->read_single();
    // Check fails, no category_id
    if (!$cat->category) {
        echo json_encode(array('message' => 'category_id Not Found'));
        exit();
    }

    // Check success- proceed with update
    if ($body->update()){
        echo json_encode(array('id'=>$body->id,'quote'=>$body->quote,'author_id'=>$body->author_id,'category_id'=>$body->category_id));
    }

    // Error message for default failure
    else
    {
       echo json_encode(array('message' => 'No Quotes Found'));
    }
