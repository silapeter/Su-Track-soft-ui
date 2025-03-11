<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();


  $doc = new DocDB($db);

        $doc->doc_id = isset($_GET['docId']) ? $_GET['docId'] : "not exist";
        $doc->comment = isset($_GET['comment']) ? $_GET['comment'] : "not exist";
        $admin = isset($_GET['admin']) ? $_GET['admin'] : "not exist";
        $token = isset($_GET['token']) ? $_GET['token'] : "not exist";


    if($database->token == $token){

            $result = $doc->reject_doc($admin);

    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>