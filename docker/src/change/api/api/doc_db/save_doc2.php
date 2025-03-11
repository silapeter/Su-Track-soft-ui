<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ppc_project_doc.php';


  $database = new Database();
  $db = $database->connect();

  $doc = new DocDB($db);

  
    $doc->dept_id = $_POST['deptId'];
    $doc->fiscal_id = $_POST['fiscalId'];
    $doc->plan_name = $_POST['planName'];
    $doc->plan_newname = $_POST['planNewName'];
    $doc->plan_change = $_POST['planChange'];
    $doc->project_name = $_POST['projectName'];
    $doc->project_newname = $_POST['projectNewName'];
    $doc->project_change = $_POST['projectChange'];
    $doc->activity_name = $_POST['activityName'];
    $doc->activity_newname = $_POST['activityNewName'];
    $doc->activity_change = $_POST['activityChange'];
    $doc->budget_am = $_POST['budgetAm'];
    $doc->budget_newam = $_POST['budgetNewAm'];
    $doc->budget_change = $_POST['budgetChange'];
    $doc->budget_source = $_POST['budgetSource'];
    $doc->change_reason = $_POST['changeReason'];
    $doc->docstatus = $_POST['docstatus'];
    $doc->main_log = $_POST['log'];
    $doc->owneremail = $_POST['owneremail'];





  $mode = $_POST['actionmode'];
  
    if($mode == 'insert') {
        $doc->doc_id = uniqid('d');
    } else {
        $doc->doc_id = $_POST['docId'];
    }

  $token = $_POST['token'];


    if($database->token == $token){
        $result = $doc->save_doc($mode);
    } else {
        
      $result = array(
                        'result' => false,
                        'error' => 'ไม่สามารถบันทึกข้อมูลกรุณาแจ้งผู้ดูแลระบบ : token Error',     
                    );
    }

          echo json_encode($result);
?>