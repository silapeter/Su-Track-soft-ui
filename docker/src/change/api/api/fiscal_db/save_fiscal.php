<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/fiscal_db.php';


  $database = new Database();
  $db = $database->connect();

  $Fiscal = new Fiscal($db);


  $Fiscal->fiscal_year = $_GET['fiscal_year'];
  $Fiscal->fiscal_type = $_GET['fiscal_type'];
  $Fiscal->fiscal_name = $_GET['fiscal_name'];
  $Fiscal->fiscal_status = $_GET['fiscal_status'];
  





  $mode = $_GET['actionmode'];
  
    if($mode == 'insert') {
        $Fiscal->fiscal_id = uniqid('d');
    } else {
        $Fiscal->fiscal_id = $_GET['fiscal_id'];
    }

  $token = $_GET['token'];


    if($database->token == $token){
        $result = $Fiscal->save_fiscal($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>