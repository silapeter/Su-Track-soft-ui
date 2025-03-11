<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/user.php';


  $database = new Database();
  $db = $database->connect();

  $usr = new User($db);

  $usr->user_id = $_GET['userid'];


  $token = $_GET['token'];


    if($database->token == $token){

      if($usr->LastAdminCheck($usr->user_id)&& $usr->user_permis == 0){
            $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถลบข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้เนื่องจากต้องมีผู้ดูแลระบบ (Admin) อย่างน้อย 1 คน',     
                    );
      } else {
            $result = $usr->del_user();
      }
        
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถลบข้อมูลผู้ใช้ในฐานข้อมูลข้อมูลได้กรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>