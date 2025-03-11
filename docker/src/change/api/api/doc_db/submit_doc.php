<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();


  $doc = new DocDB($db);

        $doc_id = isset($_GET['docId']) ? $_GET['docId'] : "not exist";
        $slog = isset($_GET['slog']) ? $_GET['slog'] : "not exist";
        $token = $_GET['token'];

    if($database->token == $token){
      // if($doc->childCheck($doc_id)){
      //       $result = array(
      //                   'result' => false,
      //                   'error' => 'ไม่สามารถลบข้อมูลได้เนืองจากมีการยืนยันข้อมูลนี้ไปแล้ว หากต้องการลบกรุณาติดต่อกองแผนงาน',     
      //               );
      // } else {
            $result = $doc->submit_doc($doc_id,$slog);
      // }
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>