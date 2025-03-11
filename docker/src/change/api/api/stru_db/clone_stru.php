<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/stru_db.php';


  $database = new Database();
  $db = $database->connect();



    $source_id = $_GET['source'];
    $target_id = $_GET['target'];
    $usrToken = $_GET['token'];


    if(($database->token == $usrToken) && !(empty($target_id)) && !(empty($source_id))){
                    $stru = new Stru($db);
                    $output_array = $stru->clone_stru($source_id,$target_id);

    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token : Data Error',     
                    );
    }




          echo json_encode($output_array);
?>


