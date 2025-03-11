<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/type_db.php';


  $database = new Database();
  $db = $database->connect();

  $type = new TypeDB($db);

  $type->type_type = $_GET['type_type'];
  $type->type_name = $_GET['type_name'];
  $type->type_status = $_GET['type_status'];
  





  $mode = $_GET['actionmode'];
  
    if($mode == 'insert') {
        $type->type_id = uniqid('d');
    } else {
        $type->type_id = $_GET['type_id'];
    }

  $token = $_GET['token'];


    if($database->token == $token){
        $result = $type->save_type($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>