<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object 
    $quote = new Quote($db);

    // Get the id from the URL
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call the read single method to get post
    $quote->read_single();

    // Create an array
    $quote_arr = array(
        'id' => $quote->id,
        'author' => $quote -> author,
        'category_id' => $quote -> category_id,
        'author_id' => $quote -> author_id
    );

    // Convert to JSON
    print_r(json_encode($post_arr));