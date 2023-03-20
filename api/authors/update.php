<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object 
    $post = new Post($db);

    // Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set id to be updated
    $post->id = $data->id;

    // Assign info in data to the post
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    // Update post
    if($post->update()){
        echo json_encode(
            array('message' => 'Post Updated')
        );
    } else { 
        echo json_encode(
            array('message' => 'Post Not Updated')
        );
    }
    
    



