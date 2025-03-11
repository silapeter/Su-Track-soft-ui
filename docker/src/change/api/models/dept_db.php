<?php
  class Dept {
    // DB Stuff
    private $conn;
    private $table = "change_dept_db";
    private $user_table = "change_user";



    public $dept_id;
    public $master_id;
    public $dept_index;
    public $dept_name;
    public $active;
    public $dept_note;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get categories
     public function dept_null()
    {

          $query = "select *, dept_id as id, master_id as master, dept_name as name, active as status, 
          dept_note as text , 1 as type FROM $this->table WHERE master_id = dept_id  ORDER BY dept_index";



        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1, $username);
        $stmt->execute();
                    return  $stmt;
    }
    
  public function dept_master($master_id,$mother_row)
    {
      $query = "select *, dept_id as id, master_id as master, dept_name as name, active as status, 
                dept_note as text , 1 as type FROM $this->table 
                WHERE master_id = ? AND master_id <> dept_id ORDER BY dept_index";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $master_id);
        $stmt->execute();
        
        //ผลิตลูกไว้ติดกับแม่
         $child_array = array();
          while($child_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $child_child_row =  $this->dept_master($child_row['id'],$child_row);   
             //ผลิตหลานแปะติดกับลูก
             array_push($child_array, $child_child_row);
          }


        //select user จาก Table user  และเพิ่มเข้าไป
        $query = "select *, user_id as id, user_dept as master,  
        CONCAT(`user_name`, \"  \" , `user_surname`, \" (\" , `user_email` , \")\") as name, 
        active as status, user_text as text, 2 as type FROM $this->user_table 
        WHERE user_dept = ? ORDER BY user_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $master_id);
        $stmt->execute();
          while($user_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($child_array, $user_row);
          }

        //แปะลูกติดกับแม่
          $mother_row['children'] = $child_array;


          return  $mother_row;
    }

    public function get_main_list($search_keywords){
      $output_array = array();

      if(empty($search_keywords)){
                $result = $this->dept_null();  
                        while($row = $result->fetch(PDO::FETCH_ASSOC)) {

                            $children =  $this->dept_master($row['id'],$row);
                            array_push($output_array, $children);
                        }
              } else {
                $output_array  = $this->search_user($search_keywords);  
              }

      return $output_array;
    }

public function get_dept_list(){
$output_array = array();
 $query = "select *, dept_id as id, master_id as master, dept_name as name, active as status, 
                dept_note as text , 1 as type FROM $this->table 
                WHERE active ORDER BY TRIM(dept_name)";

        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1, $master_id);
        $stmt->execute();
$nullRow = array("id"=>NULL,"master"=>NULL,"name"=>"กรุณาเลือกหน่วยงาน","status"=>1,"text"=>"","type"=>1);
 array_push($output_array, $nullRow);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($output_array, $row);
          }
       

    return $output_array;
}

public function get_dept_list2(){
$output_array = array();
 $query = "select *, dept_id as id, master_id as master, dept_name as name, active as status, 
                dept_note as text , 1 as type FROM $this->table 
                WHERE active ORDER BY TRIM(dept_name)";

        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1, $master_id);
        $stmt->execute();

        $nullRow = array("dept_id"=>NULL,"master_id"=>NULL,"dept_name"=>"กรุณาเลือกหน่วยงาน","status"=>1,"text"=>"","type"=>1);
        array_push($output_array, $nullRow);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($output_array, $row);
          }
       

    return $output_array;
}

public function search_user($search_txt)
    {
      if($search_txt=="admin"){
        $query = "select *, user_id as id, user_dept as master,  
        CONCAT(`user_name`, \"  \" , `user_surname`, \" (\" , `user_email` , \")\") as name, 
        active as status, user_text as text, 2 as type FROM $this->user_table 
        WHERE user_permis = 1  ORDER BY user_name";
      } else {
         $query = "select *, user_id as id, user_dept as master,  
        CONCAT(`user_name`, \"  \" , `user_surname`, \" (\" , `user_email` , \")\") as name, 
        active as status, user_text as text, 2 as type FROM $this->user_table 
        WHERE `user_name` LIKE \"%$search_txt%\" OR `user_surname` LIKE \"%$search_txt%\"  ORDER BY user_name";
      }

        $output_array = array();


        $stmt = $this->conn->prepare($query);
        $stmt->execute();
          while($user_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($output_array, $user_row);
          }
          return $output_array;
    }



 public function save_dept($saveMode)
    {


                if($saveMode == 'insert'){          

                        $query = "INSERT INTO $this->table (`master_id`, `dept_index`, 
                        `dept_name`, `active`, `dept_note`,`dept_id`) 
                        VALUES (?,?,?,?,?,?)";

                } else if($saveMode == 'update') {

                        $query = "UPDATE $this->table SET `master_id`= ? ,`dept_index`= ? ,
                        `dept_name`= ? ,`active`= ?,`dept_note`= ? 
                        WHERE  `dept_id` = ? ";

                }
                        $stmt = $this->conn->prepare($query);

                                $stmt->bindParam(1, $this->master_id);
                                $stmt->bindParam(2, $this->dept_index);
                                $stmt->bindParam(3, $this->dept_name);
                                $stmt->bindParam(4, $this->active);
                                $stmt->bindParam(5, $this->dept_note);
                                $stmt->bindParam(6, $this->dept_id);

                try {
                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูลแล้ว";
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: dept_table " . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }

public function childCheck($dept_id)
    {
        $dept_query = "SELECT * FROM $this->table d
                      WHERE d.master_id = :dept_id AND d.master_id <> d.dept_id";

        $stmt = $this->conn->prepare($dept_query);
        $stmt->bindParam(':dept_id', $dept_id);
        $stmt->execute();
        $dept_am = $stmt->rowCount();

        $user_query = "SELECT * FROM $this->user_table u WHERE u.user_dept = :dept_id";


        $stmt = $this->conn->prepare($user_query);
        $stmt->bindParam(':dept_id', $dept_id);
        $stmt->execute();
        $user_am = $stmt->rowCount();
        
                if(($dept_am+$user_am)>0) return true; else return false;

    }

    public function del_dept()
    {
                        $query = "DELETE FROM $this->table  
                        WHERE  `dept_id` = ? ";
                
                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(1, $this->dept_id);
                try {
                $stmt->execute();
                        //success
                        $errTxt = "ลบข้อมูลในฐานข้อมูล";
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถลบข้อมูลในฐานข้อมูลได้: user_table" . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }


  }
  ?>