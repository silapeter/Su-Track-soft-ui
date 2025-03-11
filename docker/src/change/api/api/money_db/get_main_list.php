<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/money_db.php';


  $database = new Database();
  $db = $database->connect();



    // $search_keywords = $_GET['keyword'];
    $usrToken = $_GET['token'];


    if($database->token == $usrToken){
                    $money = new Money($db);
                    $output_array = $money->money_master();

    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }




          echo json_encode($output_array);
?>


