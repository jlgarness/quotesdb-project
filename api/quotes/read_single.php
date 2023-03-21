<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object 
    $body = new Quote($db);

    // Get the id from the URL
    $body->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call the read single method to get post
    if($body->read_single()) {

        $quote_arr = array(
          'id' => $body->id,
          'quote' => $body->quote,
          'author' => $body->author,
          'category' => $body->category
        );
       }

    // Error message for failure
     else {
       $quote_arr = array(
         'message' => 'No Quotes Found'
       );
    
     }
    
      echo(json_encode($quote_arr));
    