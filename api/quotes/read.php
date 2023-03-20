<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quotes  object 
    $quote = new Quote($db);

    // Category read query
    $result = $quote->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any quotes exist
    if($num>0) {
        //Quote array
        $quote_arr = array();
        $quote_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quote_items = array(
                'id' => $id,
                'quote' => $quote,
                'category_id' => $category_id,
                'author_id' => $author_id  
            );

            // Push to "data" array
            array_push($quote_arr['data'], $quote_items);
        }

        // Convert to JSON & output
        echo json_encode($quote_arr);
    } else {
        // No Categories
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }