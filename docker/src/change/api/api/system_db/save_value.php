<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/system_db.php';


  $database = new Database();
  $db = $database->connect();

  $type = new SysDB($db);

    $token = $_GET['token'];
    $kk = $_GET['kk'];
    $vv = $_GET['vv'];
  
    if($database->token == $token){
        $result = $type->save_s($kk,$vv);
    } else {
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }
          echo json_encode($result);
?>