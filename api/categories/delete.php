<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object 
    $cat = new Category($db);

    // Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

   // Retrieve
   if (!isset($data->id)){
    // If no data
    echo(json_encode(array('message' => 'Missing Required Parameters'))); 
    } else {
    // Proceed with deletion
    $cat->id = $data->id;
    $cat->delete();
    echo(json_encode(array('id'=>$cat->id)));
    
    }
