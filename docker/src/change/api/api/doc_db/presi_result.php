<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

  $doc = new DocDB($db);

  
    $doc->doc_id = $_GET['doc_id'];
    $doc->step4_result = $_GET['step4_result'];
    $doc->step4_txt = $_GET['step4_txt'];
    $doc->step4_log = $_GET['slog'];


    $token = $_GET['token'];



    if($database->token == $token){
        $result = $doc->save_step4();
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>