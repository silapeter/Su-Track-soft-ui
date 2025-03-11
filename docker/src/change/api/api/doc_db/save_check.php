<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

  $doc = new DocDB($db);

    $doc->doc_id = $_GET['doc_id'];
    $admin_check = $_GET['admin_check'];
    $doc->code = $_GET['coder'];
    $token = $_GET['token'];
    $doc->adminemail = $_GET['adminemail'];
    $doc->comment = $_GET['txt'];



    if($database->token == $token){
        $result = $doc->save_check($admin_check);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>