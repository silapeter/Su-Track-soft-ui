<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/stru_db.php';


  $database = new Database();
  $db = $database->connect();

  $Dpt = new Stru($db);

  $Dpt->master_id = $_GET['strumaster'];
  $Dpt->stru_name = $_GET['struname'];
  $Dpt->stru_title = $_GET['strutitle'];
  $Dpt->active = $_GET['struactive'];
  $Dpt->bg_term_id = $_GET['bgtermid'];
  $Dpt->stru_index = 0;
  $Dpt->stru_note = "";





  $mode = $_GET['actionmode'];
  
    if($mode == 'insert') {
        $Dpt->stru_id = uniqid('s');
        if(empty($_GET['strumaster'])) {
                  $Dpt->master_id=$Dpt->stru_id;
        }
    } else {
        $Dpt->stru_id = $_GET['struid'];
    }

  $token = $_GET['token'];


    if($database->token == $token){
        $result = $Dpt->save_stru($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>