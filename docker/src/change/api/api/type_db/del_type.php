<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/type_db.php';


  $database = new Database();
  $db = $database->connect();

  $Fs = new TypeDB($db);

        $type_id = isset($_GET['type_id']) ? $_GET['type_id'] : "not exist";
        $token = $_GET['token'];

    if($database->token == $token){
      if($Fs->childCheck($type_id)){
            $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถลบข้อมูลได้เนืองจากมีการใช้งานข้อมูลนี้',     
                    );
      } else {
            $result = $Fs->del_type($type_id);
      }
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>