<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object 
    $cat = new Category($db);

    // Retrieve
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id)|| !isset($data->category)) {
        // Author not available
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    // Set properties
    $cat->category = $data->category;
    $cat->id = $data->id;
    
    // Proceed with update
    if ($cat->update()){
        echo json_encode(array('id'=>$cat->id,'category'=>$cat->category));
    }
    else
    {
        echo json_encode(array('message' => 'category_id Not Found'));
    }
