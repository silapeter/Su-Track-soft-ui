<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/inst_db.php';


  $database = new Database();
  $db = $database->connect();

  $Inst = new Instru($db);

        $token = $_GET['token'];


    if($database->token == $token){
            $result = $Inst->del_inst($_GET['instid']);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลในฐานข้อมูลข้อมูลได้กรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>