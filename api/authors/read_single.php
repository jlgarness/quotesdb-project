<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object 
    $author = new Author($db);

    // Get the id from the URL
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call the read single method to get post
    $author->read_single();

    // Create an array
    $author_arr = array(
        'id' => $author->id,
        'author' => $author -> author,
        
    );

    // Convert to JSON
    print_r(json_encode($author_arr));