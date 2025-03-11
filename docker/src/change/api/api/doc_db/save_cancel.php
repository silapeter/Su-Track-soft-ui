<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

  $doc = new DocDB($db);

    $doc->doc_id = $_GET['doc_id'];
    $doc->admin_check = $_GET['admin_check'];
    $doc->admin_log = $_GET['slog'];
    $doc->docstatus = $_GET['dstatus'];

        $token = $_GET['token'];


    if($database->token == $token){
        $result = $doc->save_cancel();
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>