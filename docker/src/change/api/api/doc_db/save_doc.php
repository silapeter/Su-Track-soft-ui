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

  
    $doc->dept_id = $data['deptId'];
    $doc->fiscal_id = $data['fiscalId'];
    $doc->plan_name = $data['planName'];
    $doc->plan_newname = $data['planNewName'];
    $doc->plan_change = $data['planChange'];
    $doc->project_name = $data['projectName'];
    $doc->project_newname = $data['projectNewName'];
    $doc->project_change = $data['projectChange'];
    $doc->activity_name = $data['activityName'];
    $doc->activity_newname = $data['activityNewName'];
    $doc->activity_change = $data['activityChange'];
    $doc->budget_am = $data['budgetAm'];
    $doc->budget_newam = $data['budgetNewAm'];
    $doc->budget_change = $data['budgetChange'];
    $doc->budget_source = $data['budgetSource'];
    $doc->change_reason = $data['changeReason'];
    $doc->docstatus = $data['docstatus'];
    $doc->main_log = $data['log'];
    $doc->owneremail = $data['owneremail'];





  $mode = $data['actionmode'];
  
    if($mode == 'insert') {
        $doc->doc_id = uniqid('d');
    } else {
        $doc->doc_id = $data['docId'];
    }

  $token = $data['token'];


    if($database->token == $token){
        $result = $doc->save_doc($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => ' token Error',     
                    );
    }

          echo json_encode($result);
?>