<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

  $doc = new DocDB($db);

  
    $doc->doc_id = $_GET['doc_id'];
    $doc->step3_result = $_GET['step3_result'];
    $doc->step3_txt = $_GET['step3_txt'];
    $doc->step3_log = $_GET['slog'];



    $token = $_GET['token'];
    $president = $_GET['president'];


    if($database->token == $token){
        $result = $doc->save_step3($president);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>