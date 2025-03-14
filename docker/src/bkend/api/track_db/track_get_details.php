<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/tracking_item.php';


  $database = new Database();
  $db = $database->connect();

    // $search_keywords = $_GET['keyword'];
    $Token = $_GET['token'];
    $itemCode = $_GET['itemCode'];
    // $dept_id = $_GET['deptId'];  

    if($database->token == $Token){
                    $doc = new itemDB($db);
                    $output_array = $doc->get_track_details($itemCode);
    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }
          echo json_encode($output_array);
?>

