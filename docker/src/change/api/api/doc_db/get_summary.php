<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

    // $search_keywords = $_GET['keyword'];
    $usrToken = $_GET['token'];
    $fiscal = $_GET['f'];  

    if($database->token == $usrToken){
                    $doc = new DocDB($db);
                    $output_array = $doc->get_summary($fiscal);
    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }
          echo json_encode($output_array);
?>


