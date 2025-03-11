<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/fiscal_db.php';

  $database = new Database();
  $db = $database->connect();



    $search_keywords = $_GET['keyword'];
    $usrToken = $_GET['token'];


    if($database->token == $usrToken){
                    $fiscal = new Fiscal($db);
                    $output_array = $fiscal->fiscal_master();

    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }




          echo json_encode($output_array);
?>


