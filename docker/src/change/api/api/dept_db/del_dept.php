<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/dept_db.php';


  $database = new Database();
  $db = $database->connect();

  $Dpt = new Dept($db);

        $Dpt->dept_id = $_GET['deptid'];
        $token = $_GET['token'];


    if($database->token == $token){
      if($Dpt->childCheck($Dpt->dept_id)){
            $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถลบข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้เนื่องจากหน่วยงานนี้ถูกผูกกับหน่วยงานอื่นหรือผู้ใช้',     
                    );
      } else {
            $result = $Dpt->del_dept();
      }
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้กรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>