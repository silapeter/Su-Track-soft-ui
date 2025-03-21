<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/user.php';


  $database = new Database();
  $db = $database->connect();

  $usr = new User($db);

  $usr->user_id = $_GET['userid'];
  $usr->user_dept = $_GET['deptid'];
  $usr->user_name = $_GET['uname'];
  $usr->user_surname = $_GET['usurname'];
  $usr->user_email = $_GET['useremail'];
  $usr->active = $_GET['useractive'];
  $usr->user_permis = $_GET['user_permis'];
  $usr->extra = $_GET['extra'];
  
  $usr->user_text = "";

  $mode = $_GET['actionmode'];
  
    if($mode == 'insert') {
        $usr->user_id = uniqid('u');
    } else {
        $usr->user_id = $_GET['userid'];
    }

  $token = $_GET['token'];


    if($database->token == $token){

      if($usr->LastAdminCheck($usr->user_id) && $usr->user_permis == 0){
            $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้เนื่องจากต้องมีผู้ดูแลระบบ (Admin) อย่างน้อย 1 คน',     
                    );
      } else {
            $result = $usr->save_user($mode);
      }
        
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้กรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>