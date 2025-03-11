<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/inst_db.php';


  $database = new Database();
  $db = $database->connect();

  $InstP = new Instru($db);


  $InstP->dept_id = $_GET['dept_id'];
  $InstP->stru_id = $_GET['stru_id'];
  $InstP->log = $_GET['log'];
  $InstP->inst_id = $_GET['inst_id'];





  $mode = $_GET['actionmode'];
  
    if($mode == 'insert') {
        $InstP->inst_id = uniqid('d');
    } 
  $token = $_GET['token'];


    if($database->token == $token){
      if($InstP->checkDup()){
            $result = array(
                        'result' => false,
                        'error' => 'มีหน่วยงานนี้ในโครงสร้างนี้แล้ว กรุณาตรวจสอบ',     
                          );
      } else {
            $result = $InstP->save_inst($mode);
      }
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้กรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>