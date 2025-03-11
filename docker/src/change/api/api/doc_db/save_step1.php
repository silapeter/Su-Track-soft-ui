<?php
date_default_timezone_set("Asia/Bangkok");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST,GET");
header("Content-Type: application/json; charset=UTF-8");

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

  $doc = new DocDB($db);

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);
 
    $doc->doc_id = $data['doc_id'];
    $doc->step1_result = $data['step1_result'];
    $doc->step1_result_code = $data['step1_result_code'];
    $doc->step1_result_txt = $data['step1_result_txt'];
    $doc->step1_objective_result = $data['step1_objective_result'];
    $doc->step1_objective_txt = $data['step1_objective_txt'];
    $doc->step1_available_result = $data['step1_available_result'];
    $doc->step1_available_code = $data['step1_available_code'];
    $doc->step1_available_name = $data['step1_available_name'];
    $doc->step1_available_txt = $data['step1_available_txt'];
    $doc->activity_change = $data['activity_change'];
    $doc->step1_target_result = $data['step1_target_result'];
    $doc->step1_target_txt = $data['step1_target_txt'];
    $doc->step1_log = $data['slog'];
    $doc->docstatus = $data['dstatus'];
    $doc->president_step = $data['president_step'];

        $token = $data['token'];


    if($database->token == $token){
        $result = $doc->save_step1($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>