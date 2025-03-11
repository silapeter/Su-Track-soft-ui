<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/dept_db.php';


  $database = new Database();
  $db = $database->connect();

  $Dpt = new Dept($db);

  $Dpt->master_id = $_GET['deptmaster'];
  $Dpt->dept_name = $_GET['deptname'];
  $Dpt->active = $_GET['deptactive'];
  $Dpt->dept_index = 0;
  $Dpt->dept_note = "";


// mysql_real_escape_string


  $mode = $_GET['actionmode'];
  
    if($mode == 'insert') {
        $Dpt->dept_id = uniqid('d');
    } else {
        $Dpt->dept_id = $_GET['deptid'];
    }

  $token = $_GET['token'];


    if($database->token == $token){
        $result = $Dpt->save_dept($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้กรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>