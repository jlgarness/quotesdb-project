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
    $category = new Category($db);

    // Get the id from the URL
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call the read single method to get category
    $category->read_single();

    // Create an array
    $cat_arr = array(
        'id' => $category->id,
        'category'=> $category -> category,
        
    );

    // Convert to JSON
    print_r(json_encode($cat_arr));