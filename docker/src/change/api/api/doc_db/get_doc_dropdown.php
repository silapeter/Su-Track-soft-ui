<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();



    // $id = $_GET['id'];
    $usrToken = $_GET['token'];


    if($database->token == $usrToken){
                    $money = new TypeDB($db);
                    $output_array = $money->doc_dropdown();

    } else {
      $output_array = array(
                       'error' => 'no token available or invalid token',     
                    );
    }




          echo json_encode($output_array);
?>


