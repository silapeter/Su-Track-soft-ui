<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/money_db.php';


  $database = new Database();
  $db = $database->connect();

  $Fs = new Money($db);

        $money_id = isset($_GET['money_id']) ? $_GET['money_id'] : "not exist";
        $token = $_GET['token'];

    if($database->token == $token){
      if($Fs->childCheck($money_id)){
            $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถลบข้อมูลได้เนืองจากมีการใช้งานข้อมูลนี้',     
                    );
      } else {
            $result = $Fs->del_money($money_id);
      }
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>