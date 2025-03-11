<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/stru_db.php';


  $database = new Database();
  $db = $database->connect();


    $usrToken = $_GET['token'];


    if($database->token == $usrToken){
                    $stru = new Stru($db);
                    $output_array = $stru->get_stru_list();

    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }




          echo json_encode($output_array);
?>


