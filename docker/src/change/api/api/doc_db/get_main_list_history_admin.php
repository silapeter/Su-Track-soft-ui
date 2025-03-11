<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

    // $search_keywords = $_GET['keyword'];
    $usrToken = $_GET['token'];
    // $dept_id = $_GET['deptId'];  

    if($database->token == $usrToken){
                    $type = new DocDB($db);
                    $output_array = $type->doc_dropdown_history_admin();
    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }
          echo json_encode($output_array);
?>


