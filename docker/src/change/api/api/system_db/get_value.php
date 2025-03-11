<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/system_db.php';


  $database = new Database();
  $db = $database->connect();

    // $search_keywords = $_GET['keyword'];
    $usrToken = $_GET['token'];
    $kk = $_GET['kk'];

    if($database->token == $usrToken){
                    $type = new SysDB($db);
                    $output_array = $type->get_s($kk);
    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }
          echo json_encode($output_array);
?>


