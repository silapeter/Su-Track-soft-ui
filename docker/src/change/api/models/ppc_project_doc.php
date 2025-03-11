<?php
  class DocDB {
    // DB Stuff
    private $conn;
    private $table = "change_project_doc";
    private $fiscal_table = "change_fiscal_db";
    private $status_table = "change_doc_status";
    private $dept_table = "change_dept_db";
    private $admin_check_table = "change_admin_check_st";


    public $doc_id;
    public $dept_id;
    public $fiscal_id;
    public $plan_name;
    public $plan_newname;
    public $plan_change;
    public $project_name;
    public $project_newname;
    public $project_change;
    public $activity_name;
    public $activity_newname;
    public $activity_change;
    public $budget_am;
    public $budget_newam;
    public $budget_change;
    public $budget_source;
    public $change_reason;
    public $admin_check;
    public $admin_log;

    public $step1_result;
    public $step1_result_txt;
    public $step1_result_code; 
    public $step1_objective_result;
    public $step1_objective_txt;
    public $step1_available_result;
    public $step1_available_code;
    public $step1_available_name;
    public $step1_available_txt;
    public $step1_target_result;
    public $step1_target_txt;
    public $step1_log;
    public $step2_result;
    public $step2_txt;
    public $step2_log;
    public $step3_result;
    public $step3_txt;
    public $step3_log;
    public $step4_result;
    public $step4_txt;
    public $step4_log;
    public $main_log;
    public $docstatus;
    public $owneremail;
    public $adminemail;
    public $comment;
    public $code;
    public $time_enter;
    public $time_check;
    public $time_confirm;
    public $time_step1;
    public $time_step2;
    public $time_step3;
    public $president_step;
    


    public function __construct($db) {
      $this->conn = $db;
    }


    
//   public function type_master()
//     {
//         $output_array = array();
//         $query = "select *, m.type_id as id, 'master_id' as master, m.type_name as name, m.type_status as status, 
//                 'text' as text , m.type_type as type  FROM $this->table m
//                 WHERE 1 ORDER BY m.type_name DESC";

//         $stmt = $this->conn->prepare($query);
  
//         $stmt->execute();
        
//           while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
//              array_push($output_array, $result);
//           }


//           return  $output_array;
//     }
        public function thaidate(){

                $strDate =  date("Y/n/j H:i:s");
                $strYear = date("Y",strtotime($strDate))+543;
                $strMonth =date ("n",strtotime($strDate));
                $strDay =date ("j",strtotime($strDate));
                $strHour =date ("H",strtotime($strDate));
                $strMinute =date ("i",strtotime($strDate));
                $strSeconds =date ("s",strtotime($strDate));
                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                $strMonthThai = $strMonthCut[$strMonth];

                return "$strDay $strMonthThai $strYear, $strHour:$strMinute:$strSeconds";
        }

      public function doc_dropdown($dept_id)
    {
        $i = 1;
        $output_array = array();
        $query = "select *, d.doc_id as id,acc.details as stdetails, 'master_id' as master,d.project_name  as name, s.status_name as status, f.fiscal_year as year,
                'text' as text , 'change_type' as type FROM $this->table d
                left join $this->fiscal_table f on d.fiscal_id = f.fiscal_id
                left join $this->status_table s on d.docstatus = s.status_id
                left join $this->admin_check_table acc on d.admin_check = acc.st  
                WHERE d.dept_id = :deptid AND d.docstatus < 400 ORDER BY d.timeslog DESC";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':deptid', $dept_id);
        $stmt->execute();
             
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $i = 0;
             array_push($output_array, $result);
          }

        //   if($i)array_push($output_array,array("id" => "0000", "name" => "ไม่มีข้อมูล", "type_id" => "0000"));   


          return  $output_array;
    }

      public function doc_dropdown_history($dept_id)
    {
        $i = 1;
        $output_array = array();
        $query = "select *, d.doc_id as id, 'master_id' as master, IF(d.president_step <> 1 , d.project_name , CONCAT('* ' ,d.project_name))  as name, dt.dept_name ,s.status_name as status, f.fiscal_year as year,
                'text' as text , 'change_type' as type FROM $this->table d
                left join $this->fiscal_table f on d.fiscal_id = f.fiscal_id
                left join $this->status_table s on d.docstatus = s.status_id
                left join $this->dept_table dt on dt.dept_id = d.dept_id
                WHERE d.dept_id = :deptid AND d.docstatus >= 300 ORDER BY d.timeslog DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':deptid', $dept_id);
        $stmt->execute();
             
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $i = 0;
             array_push($output_array, $result);
          }

        //   if($i)array_push($output_array,array("id" => "0000", "name" => "ไม่มีข้อมูล", "type_id" => "0000"));   


          return  $output_array;
    }

      public function get_doc_details($doc_id)
    {
        $query = "select *, d.doc_id as id, 'master_id' as master,d.project_name  as name, s.status_name as status, f.fiscal_year as year, dt.dept_name as dept_name,
                'text' as text , 'change_type' as type FROM $this->table d
                left join $this->fiscal_table f on d.fiscal_id = f.fiscal_id
                left join $this->status_table s on d.docstatus = s.status_id
                left join $this->dept_table dt on d.dept_id = dt.dept_id
                WHERE d.doc_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $doc_id);
        $stmt->execute();
  
          if($stmt->rowCount()>0){
           $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $row = array("result"=>true,"data"=>$data);
          } else {
                $row = array("result"=>false,"doc_id"=>$doc_id);
          }
          return  $row;
    }



      public function doc_dropdown_history_admin()
    {
        $i = 1;
        $output_array = array();
        $query = "select *, d.doc_id as id, 'master_id' as master, IF(d.president_step <> 1 , CONCAT(dt.dept_name, ' : ' ,d.project_name) ,  CONCAT('*',dt.dept_name, ' : ' ,d.project_name))  as name, s.status_name as status, f.fiscal_year as year, dt.dept_name as dept_name,
                'text' as text , 'change_type' as type FROM $this->table d
                left join $this->fiscal_table f on d.fiscal_id = f.fiscal_id
                left join $this->status_table s on d.docstatus = s.status_id 
                left join $this->dept_table dt on d.dept_id = dt.dept_id
                WHERE  d.docstatus >= 600 ORDER BY d.timeslog DESC";

        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(':deptid', $dept_id);
        $stmt->execute();
             
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $i = 0;
             array_push($output_array, $result);
          }

        //   if($i)array_push($output_array,array("id" => "0000", "name" => "ไม่มีข้อมูล", "type_id" => "0000"));   


          return  $output_array;
    }
      public function doc_dropdown_process_admin($sTatus)
    {
        $i = 1;
        $output_array = array();
        
        if($sTatus == 600) {
        $query = "select *, d.doc_id as id,acc.details as stdetails, 'master_id' as master,IF(d.president_step = 1 ,CONCAT('* ', d.project_name) , d.project_name )  as name, s.status_name as status, f.fiscal_year as year, dt.dept_name as dept_name,
                'text' as text , 'change_type' as type FROM $this->table d
                left join $this->fiscal_table f on d.fiscal_id = f.fiscal_id
                left join $this->status_table s on d.docstatus = s.status_id 
                left join $this->dept_table dt on d.dept_id = dt.dept_id
                left join $this->admin_check_table acc on d.admin_check = acc.st 
                WHERE  d.docstatus >= ?  ORDER BY d.timeslog DESC";
                } else {
                $query = "select *, d.doc_id as id,acc.details as stdetails, 'master_id' as master,IF(d.president_step = 1 ,CONCAT('* ', d.project_name) , d.project_name )  as name, s.status_name as status, f.fiscal_year as year, dt.dept_name as dept_name,
                'text' as text , 'change_type' as type FROM $this->table d
                left join $this->fiscal_table f on d.fiscal_id = f.fiscal_id
                left join $this->status_table s on d.docstatus = s.status_id 
                left join $this->dept_table dt on d.dept_id = dt.dept_id
                left join $this->admin_check_table acc on d.admin_check = acc.st 
                WHERE  d.docstatus = ?  ORDER BY d.timeslog DESC";
                } 

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $sTatus);
        $stmt->execute();
             
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $i = 0;
             array_push($output_array, $result);
          }

        //   if($i)array_push($output_array,array("id" => "0000", "name" => "ไม่มีข้อมูล", "type_id" => "0000"));   


          return  $output_array;
    }

 public function save_doc($saveMode)
    {

                if($saveMode == 'insert'){          
                        $query = "INSERT INTO $this->table (`doc_id`, `dept_id`, `fiscal_id`, `plan_name`, `plan_newname`, `plan_change`, `project_name`,`project_newname`, `project_change`, `activity_name`, `activity_newname`, `activity_change`, `budget_am`, `budget_newam`, `budget_change`, `budget_source`, `change_reason`,`main_log`,`docstatus`, `timeslog`,`owneremail`,`time_enter`) VALUES (:doc_id, :dept_id, :fiscal_id, :plan_name, :plan_newname, :plan_change, :project_name, :project_newname, :project_change, :activity_name, :activity_newname, :activity_change, :budget_am, :budget_newam, :budget_change, :budget_source, :change_reason,  :main_log, :docstatus, sysdate(),:owneremail,curdate())";
                                
                        $stmt = $this->conn->prepare($query);
                        
                                $stmt->bindParam(':doc_id', $this->doc_id);
                                $stmt->bindParam(':dept_id', $this->dept_id);
                                $stmt->bindParam(':fiscal_id', $this->fiscal_id);
                                $stmt->bindParam(':plan_name', $this->plan_name);
                                $stmt->bindParam(':plan_newname', $this->plan_newname);
                                $stmt->bindParam(':plan_change', $this->plan_change);
                                $stmt->bindParam(':project_name', $this->project_name);
                                $stmt->bindParam(':project_newname', $this->project_newname);
                                $stmt->bindParam(':project_change', $this->project_change);
                                $stmt->bindParam(':activity_name', $this->activity_name);
                                $stmt->bindParam(':activity_newname', $this->activity_newname);
                                $stmt->bindParam(':activity_change', $this->activity_change);
                                $stmt->bindParam(':budget_am', $this->budget_am);
                                $stmt->bindParam(':budget_newam', $this->budget_newam);
                                $stmt->bindParam(':budget_change', $this->budget_change);
                                $stmt->bindParam(':budget_source', $this->budget_source);
                                $stmt->bindParam(':change_reason', $this->change_reason);
                                $timelog=$this->main_log . $this->thaidate();
                                $stmt->bindParam(':main_log', $timelog);
                                $stmt->bindParam(':docstatus', $this->docstatus);
                                $stmt->bindParam(':owneremail', $this->owneremail);
                                // $stmt->bindParam(':timeslog', date());

                } else if($saveMode == 'update') {
                        $query = "UPDATE $this->table SET 
                        `plan_name` = :plan_name, `plan_newname` = :plan_newname, `plan_change` = :plan_change,`project_name` = :project_name,
                        `project_newname` = :project_newname, `project_change` = :project_change, `activity_name` = :activity_name,
                        `activity_newname` = :activity_newname, `activity_change` = :activity_change, `budget_am` = :budget_am,
                        `budget_newam` = :budget_newam, `budget_change` = :budget_change, `budget_source` = :budget_source,
                        `change_reason` = :change_reason, `main_log` = :main_log, `admin_check` = 9
                        WHERE  `doc_id` = :doc_id ";

                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(':doc_id', $this->doc_id);
                                $stmt->bindParam(':plan_name', $this->plan_name);
                                $stmt->bindParam(':plan_newname', $this->plan_newname);
                                $stmt->bindParam(':plan_change', $this->plan_change);
                                $stmt->bindParam(':project_name', $this->project_name);
                                $stmt->bindParam(':project_newname', $this->project_newname);
                                $stmt->bindParam(':project_change', $this->project_change);
                                $stmt->bindParam(':activity_name', $this->activity_name);
                                $stmt->bindParam(':activity_newname', $this->activity_newname);
                                $stmt->bindParam(':activity_change', $this->activity_change);
                                $stmt->bindParam(':budget_am', $this->budget_am);
                                $stmt->bindParam(':budget_newam', $this->budget_newam);
                                $stmt->bindParam(':budget_change', $this->budget_change);
                                $stmt->bindParam(':budget_source', $this->budget_source);
                                $stmt->bindParam(':change_reason', $this->change_reason);
                                $stmt->bindParam(':main_log', $this->main_log);
                                // $stmt->bindParam(':docstatus', $this->docstatus);
                }
                       
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว" ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }
 public function save_step1()
    {          
        
                        $query = "UPDATE $this->table SET 
                        `step1_result`=:step1_result,`step1_result_code`=:step1_result_code,`step1_result_txt`=:step1_result_txt,`step1_objective_result`=:step1_objective_result,
                        `step1_objective_txt`=:step1_objective_txt,`step1_available_result`=:step1_available_result,`step1_available_code`=:step1_available_code,
                        `step1_available_name`=:step1_available_name,`step1_available_txt`=:step1_available_txt,`step1_target_result`=:step1_target_result,`step1_target_txt`=:step1_target_txt,
                        `step1_log`=:step1_log,`docstatus`= :docstatus,`time_step1`= curdate(),`president_step`= :president_step
                         WHERE  `doc_id` = :doc_id ";

                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(':doc_id', $this->doc_id);
                                $stmt->bindParam(':step1_result', $this->step1_result);
                                $stmt->bindParam(':step1_result_code', $this->step1_result_code);
                                $stmt->bindParam(':step1_result_txt', $this->step1_result_txt);
                                $stmt->bindParam(':step1_objective_result', $this->step1_objective_result);
                                $stmt->bindParam(':step1_objective_txt', $this->step1_objective_txt);
                                $stmt->bindParam(':step1_available_result', $this->step1_available_result);
                                $stmt->bindParam(':step1_available_code', $this->step1_available_code);
                                $stmt->bindParam(':step1_available_name', $this->step1_available_name);
                                $stmt->bindParam(':step1_available_txt', $this->step1_available_txt);
                                $stmt->bindParam(':step1_target_result', $this->step1_target_result);
                                $stmt->bindParam(':step1_target_txt', $this->step1_target_txt);
                                $stmt->bindParam(':docstatus', $this->docstatus);
                                $timelog=$this->step1_log . $this->thaidate();
                                $stmt->bindParam(':step1_log', $timelog);
                                $stmt->bindParam(':president_step', $this->president_step);

                                // $stmt->bindParam(':docstatus', $this->docstatus);
                
                       
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว" ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }

public function save_code()

    {          
                        $query = "UPDATE $this->table SET `code` = ?
                         WHERE  `doc_id` = ?"; 

                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(1, $this->code);
                        $stmt->bindParam(2, $this->doc_id);
             
                               

                                // $stmt->bindParam(':docstatus', $this->docstatus);
                
                       
                try {

                $stmt->execute();
                        //success
                        $errTxt = "ออกรหัสยืนยันและบันทึกแล้ว" ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถดำเนินการรหัสยืนยันได้ : Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }        
 public function save_check($i)

    {          
                        $query = "UPDATE $this->table SET `admin_check` = ?, `adminemail` = ?, `comment` = ?, `code` = ?,`time_check`= curdate()
                         WHERE  `doc_id` = ?"; 

                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(1, $i);
                        $stmt->bindParam(2, $this->adminemail);
                        $stmt->bindParam(3, $this->comment);
                        $stmt->bindParam(4, $this->code);
                        $stmt->bindParam(5, $this->doc_id);
             
                               

                                // $stmt->bindParam(':docstatus', $this->docstatus);
                
                       
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว" ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }

 public function save_cancel()

    {          
         $timelog=$this->admin_log . $this->thaidate();

                        $query = "UPDATE $this->table SET `admin_check` = ?, `admin_log` = ?, `docstatus` = ?
                         WHERE  `doc_id` = ?";

                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(1, $this->admin_check);
                        $stmt->bindParam(2, $this->$timelog);
                        $stmt->bindParam(3, $this->docstatus);
                        $stmt->bindParam(4, $this->doc_id);
             
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว" ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }

 public function reject_doc($adminemail){

        
                        $query = "UPDATE $this->table SET 
                        `step1_log`=:step1_log,`docstatus`= :dstatus, `comment`= :comment
                        WHERE  `doc_id` = :doc_id ";
                        $stlog = $adminemail . " " . $this->thaidate();
                        $dstat = 900;
                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(':doc_id', $this->doc_id);
                                $stmt->bindParam(':step1_log', $stlog);
                                $stmt->bindParam(':dstatus', $dstat);
                                $stmt->bindParam(':comment', $this->comment);
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว" ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;

 }


 public function save_step2()
    {          
        if($this->step2_result==1) $docstatus = 500; else $docstatus = 800;

                        $query = "UPDATE $this->table SET 
                        `step2_result`=:step2_result,`step2_txt`=:step2_txt,`step2_log`=:step2_log,`docstatus`= :dstatus,`time_step2`= curdate()
                         WHERE  `doc_id` = :doc_id ";

                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(':doc_id', $this->doc_id);
                                $stmt->bindParam(':step2_result', $this->step2_result);
                                $stmt->bindParam(':step2_txt', $this->step2_txt);
                                $timelog=$this->step2_log . $this->thaidate();
                                $stmt->bindParam(':step2_log', $timelog);
                                $stmt->bindParam(':dstatus',$docstatus);
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว" ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }
 public function save_step3($p)
    {
                $randomNum = substr(str_shuffle("01234567890123456789012345678901234567890123456789"), 0, 5);

        if((int)$this->step3_result===1) {
                
                $docstatus = (int)$p === 1 ? 550 : 600;

                } else $docstatus = 700;

                        $query = "UPDATE $this->table SET 
                        `step3_result`=:step3_result,`step3_txt`=:step3_txt,`step3_log`=:step3_log,`docstatus`= :dstatus,`time_step3`= curdate(),`code`= :code
                         WHERE  `doc_id` = :doc_id ";

                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(':doc_id', $this->doc_id);
                                $stmt->bindParam(':step3_result', $this->step3_result);
                                $stmt->bindParam(':step3_txt', $this->step3_txt);
                                $timelog=$this->step3_log . $this->thaidate();
                                $stmt->bindParam(':step3_log', $timelog);
                                $stmt->bindParam(':dstatus',$docstatus);
                                $stmt->bindParam(':code', $randomNum);
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว" ;
                        $result = array(
                        'confcode' => $randomNum,
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }

        public function save_step4()
        {
                if ((int)$this->step4_result === 1) {

                        $docstatus = 600;

                } else $docstatus = 700;

                $query = "UPDATE $this->table SET 
                        `step4_result`=:step4_result,`step4_txt`=:step4_txt,`step4_log`=:step4_log,`docstatus`= :dstatus,`time_step4`= curdate()
                         WHERE  `doc_id` = :doc_id ";

                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':doc_id', $this->doc_id);
                $stmt->bindParam(':step4_result', $this->step4_result);
                $stmt->bindParam(':step4_txt', $this->step4_txt);
                $timelog = $this->step4_log . $this->thaidate();
                $stmt->bindParam(':step4_log', $timelog);
                $stmt->bindParam(':dstatus', $docstatus);

                try {

                        $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว";
                        $result = array(
                                'result' => true,
                                'error' => $errTxt,
                        );
                } catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                        $result = array(
                                'result' => false,
                                'error' => $errTxt,
                        );
                }

                return $result;
        }

 public function doc_status($st)
    {          
                        $query = "UPDATE $this->table SET `docstatus`= :dstatus,`step1_log`= :step1_log WHERE  `doc_id` = :doc_id ";

                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(':dstatus', $st);
                                $stmt->bindParam(':step1_log', $this->step1_log);
                                $stmt->bindParam(':doc_id', $this->doc_id);
                       
                try {

                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว 555 " . $this->doc_id  ;
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }

// public function childCheck($id)
//     {
//         $query = "SELECT * FROM $this->doc_table d
//                       WHERE d.type_id = ?";

//         $stmt = $this->conn->prepare($query);
//         $stmt->bindParam(1,$id);
//         $stmt->execute();
//         $type_am = $stmt->rowCount();
        
//                 if($type_am>0) return true; else return false;
//     }

public function get_summary($f) {

        $output_array = array();
        $query = "SELECT SUM(IF(`docstatus`=600, 1, 0)) AS approvedoc, SUM(IF(`docstatus`=700, 1, 0)) AS unapprovedoc ,
        SUM(IF(`docstatus`=800, 1, 0)) AS rejectdoc,SUM(IF(`docstatus`=900, 1, 0)) AS canceldoc, SUM(IF(`docstatus`>=600, 1, 0)) as alldoc FROM $this->table  
        WHERE `fiscal_id` = ?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $f);
        $stmt->execute();
             
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //   if($i)array_push($output_array,array("id" => "0000", "name" => "ไม่มีข้อมูล", "type_id" => "0000"));   


          return  $result;
    }

    public function del_doc($id)
    {
                        $query = "DELETE FROM $this->table  
                        WHERE  `doc_id` = ?";
                
                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(1, $id);
                try {
                $stmt->execute();
                        //success
                        $errTxt = "ลบข้อมูลในฐานข้อมูลแล้ว";
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถลบข้อมูลในฐานข้อมูลได้: API error : type_table" . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }
    public function submit_doc($id,$log)
    {
                        $query = " UPDATE $this->table  SET `submit_log`=?,`docstatus`= 200 ,`time_confirm`= curdate()
                        WHERE  `doc_id` = ?";
                
                        $stmt = $this->conn->prepare($query);
                                $timelog=$log . $this->thaidate();
                                $stmt->bindParam(1, $timelog);
                                $stmt->bindParam(2, $id);
                try {
                $stmt->execute();
                        //success
                        $errTxt = "ยืนยันข้อมูลข้อมูลแล้ว";
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถลบข้อมูลในฐานข้อมูลได้: API error : doc_table" . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }


  }

  ?>