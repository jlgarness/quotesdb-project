<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instatiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quotes  object 
    $quote_all = new Quote($db);

    // Retrieve data if available 
    if (isset($_GET['author_id'])) $quote_all->author_id = $_GET['author_id'];
    if (isset($_GET['category_id'])) $quote_all->category_id = $_GET['category_id'];

    // Get database results
    $result = $quote_all->read();

    // Get row count
    $num = $result->rowCount();

    // If rows exist, create array
    if ($num > 0)
    {
      $quote_all_arr = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $quote_item = array(
              'id' => $id,
              'quote' => html_entity_decode($quote),
              'author' => $author,
              'category' => $category
          );

      array_push($quotes_all_arr, $quote_item);
      }
      // Echo array in json
      echo json_encode($quotes_all_arr);

    }

    // Error message for failure
    else {
      echo json_encode(array('message' => "No Quotes Found!"));
    }
