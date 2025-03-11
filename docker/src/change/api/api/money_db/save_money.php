<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/money_db.php';


  $database = new Database();
  $db = $database->connect();

  $money = new Money($db);

  $money->money_type = $_GET['money_type'];
  $money->money_name = $_GET['money_name'];
  $money->money_status = $_GET['money_status'];
  





  $mode = $_GET['actionmode'];
  
    if($mode == 'insert') {
        $money->money_id = uniqid('d');
    } else {
        $money->money_id = $_GET['money_id'];
    }

  $token = $_GET['token'];


    if($database->token == $token){
        $result = $money->save_money($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>