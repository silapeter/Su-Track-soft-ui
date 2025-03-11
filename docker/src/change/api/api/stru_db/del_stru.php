<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/stru_db.php';


  $database = new Database();
  $db = $database->connect();

  $Dpt = new Stru($db);

        $Dpt->stru_id = $_GET['struid'];
        $token = $_GET['token'];


    if($database->token == $token){
      if($Dpt->childCheck($Dpt->stru_id)){
            $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถลบข้อมูลได้เนืองจากมีการใช้งานข้อมูลนี้',     
                    );
      } else {
            $result = $Dpt->del_stru();
      }
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>