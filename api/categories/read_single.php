<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate cat object 
    $cat = new Category($db);

    // Get the id from the URL
    $cat->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call the read single method to get category
    if($cat->read_single()) {

        echo json_encode(array(
          'id' => $cat->id,
          'category' => $cat->category
        ));
      }
      // If category_id is not found- error message
    else {
        echo json_encode(array(
        'message' => 'category_id Not Found'
      ));
  
    }
  