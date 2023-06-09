<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category  object 
    $cat = new Category($db);

    // Category read query
    $result = $cat->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any categories exist
    if($num>0) {
        //Cat array
        $cat_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $cat_item = array(
                'id' => $id,
                'category' => $category         
            );

            // Push to array
            array_push($cat_arr, $cat_item);
        }

        // Convert to JSON & output
        echo json_encode($cat_arr);
    } else {
        // No Categories
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }