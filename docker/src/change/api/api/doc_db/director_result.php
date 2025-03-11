<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

  $doc = new DocDB($db);

  
    $doc->doc_id = $_GET['doc_id'];
    $doc->step2_result = $_GET['step2_result'];
    $doc->step2_txt = $_GET['step2_txt'];
    $doc->step2_log = $_GET['slog'];


  $token = $_GET['token'];


    if($database->token == $token){
        $result = $doc->save_step2();
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>