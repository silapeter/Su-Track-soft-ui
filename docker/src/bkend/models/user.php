<?php
  class User {
    // DB Stuff
    private $conn;
    private $table = "track_user";
    private $depttable = "track_dept_db";


    public $user_id;
    public $user_email;
    public $user_permis;
    public $user_dept;
    public $user_name; 
    public $user_surname;
    public $user_text;
    public $active;
    public $extra;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // บันทึกรายการลงทะเบียน
     public function regis()
    {
                 

                        $query = "INSERT INTO $this->table (`user_email`, `user_permis`, 
                        `user_dept`, `user_name`, `user_surname`, 
                        `user_text`, `active`,`extra`,`user_id`) 
                        VALUES (?,?,?,?,?,?,?,?,?)";

             
                        $stmt = $this->conn->prepare($query);

                                $stmt->bindParam(1, $this->user_email);
                                $stmt->bindParam(2, $this->user_permis);
                                $stmt->bindParam(3, $this->user_dept);
                                $stmt->bindParam(4, $this->user_name);
                                $stmt->bindParam(5, $this->user_surname);
                                $stmt->bindParam(6, $this->user_text);
                                $stmt->bindParam(7, $this->active);
                                $stmt->bindParam(8, $this->extra);
                                $stmt->bindParam(9, $this->user_id);
                try {
                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูล";
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: user_table" . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
    }

    
       // ตรวจสอบอีเมลซ้ำ
     public function _check_exit_email($email)
    {
        
        $query = "SELECT  * FROM  $this->table  u WHERE u.`user_email` = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
                    $result = array(
                            'found' => 1
                    );
        }   else {
                    $result = array(
                       'userdata' => null ,
                            'found' => 0
                    );
        }
                    return $result;

    }




    // OLD Section ------------------------

    public function save_user($saveMode)
    {


                if($saveMode == 'insert'){          

                        $query = "INSERT INTO $this->table (`user_email`, `user_permis`, 
                        `user_dept`, `user_name`, `user_surname`, 
                        `user_text`, `active`,`extra`,`user_id`) 
                        VALUES (?,?,?,?,?,?,?,?,?)";

                } else if($saveMode == 'update') {

                        $query = "UPDATE $this->table SET `user_email`= ? ,`user_permis`= ? ,
                        `user_dept`= ? ,`user_name`= ?,`user_surname`= ?,`user_text`= ?,`active`= ?, `extra`= ? 
                        WHERE  `user_id` = ? ";

                }
                        $stmt = $this->conn->prepare($query);

                                $stmt->bindParam(1, $this->user_email);
                                $stmt->bindParam(2, $this->user_permis);
                                $stmt->bindParam(3, $this->user_dept);
                                $stmt->bindParam(4, $this->user_name);
                                $stmt->bindParam(5, $this->user_surname);
                                $stmt->bindParam(6, $this->user_text);
                                $stmt->bindParam(7, $this->active);
                                $stmt->bindParam(8, $this->extra);
                                $stmt->bindParam(9, $this->user_id);
                try {
                $stmt->execute();
                        //success
                        $errTxt = "บันทึกข้อมูลในฐานข้อมูล";
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: user_table" . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
    }

     public function _UserLogin($username)
    {
        
        $query = "SELECT *,d.dept_name as dept_name , d.ext as ext FROM $this->table u 
                    LEFT JOIN $this->depttable d 
   		                    ON u.user_dept = d.dept_id 
                        WHERE u.active = 1 AND u.user_email = ? ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
                    $result = array(
                            'userdata' => $result ,
                            'login' => 1
                    );
        }   else {
                    $result = array(
                       'userdata' => null ,
                            'login' => 0
                    );
        }
                    return $result;
    }

      public function _AdminLogin($username)
    {
        
        $query = "SELECT * FROM $this->table u 
                    LEFT JOIN $this->depttable d 
   		                    ON u.user_dept = d.dept_id 
                                    WHERE u.active = 1 AND u.user_permis = 1 AND u.user_email = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();

        if($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
                    $result = array(
                            'userdata' => $result ,
                            'login' => 1
                    );
        }   else {
                    $result = array(
                       'error' => "สำหรับผู้ดูแลระบบเท่านั้น" ,
                            'login' => 0
                    );

        }
                    return $result;

    }
    
      public function _DirectorLogin($email)
    {
        
        $query = "SELECT *,u.s_value as user_email,(SELECT s_value FROM $this->systable WHERE s_key = 'plan_director_name') as user_name FROM $this->systable u 
                                    WHERE u.s_key = 'plan_director_email' AND u.s_value =  ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
                    $result = array(
                            'userdata' => $result ,
                            'login' => 1
                    );
        }   else {
                    $result = array(
                       'error' => "สำหรับผู้อำนวยการกองแผนงานเท่านั้น" ,
                            'login' => 0
                    );

        }
                    return $result;

    }
      public function _ViceLogin($email)
    {
        
        $query = "SELECT *,u.s_value as user_email,(SELECT s_value FROM $this->systable WHERE s_key = 'plan_vice_name') as user_name FROM $this->systable u 
                                    WHERE u.s_key = 'plan_vice_email' AND u.s_value =  ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
                    $result = array(
                            'userdata' => $result ,
                            'login' => 1
                    );
        }   else {
                    $result = array(
                       'error' => "สำหรับผู้อำนวยการกองแผนงานเท่านั้น" ,
                            'login' => 0
                    );

        }
                    return $result;

    }

    public function profile_update()
    {
          
        $query = "UPDATE $this->table SET `user_name`= ? ,`user_surname`= ? ,`user_text`= ?
                       WHERE  user_email = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_name);
        $stmt->bindParam(2, $this->user_surname);
        $stmt->bindParam(3, $this->user_text);
        $stmt->bindParam(4, $this->user_email);
    
      

        if($stmt->execute())
        {

                    $result = array(
                            'workstatus' => 1
                    );



        }   else {
                    $result = array(
                            'workstatus' => 0
                    );

        }
                    return $result;
    }




public function del_user()
    {
                        $query = "DELETE FROM $this->table  
                        WHERE  `user_id` = ? ";
                
                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(1, $this->user_id);
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

  public function LastAdminCheck($admin_id)
    {
        
        $query = "SELECT * FROM $this->table u 
                    LEFT JOIN $this->depttable d 
   		                    ON u.user_dept = d.dept_id 
                                    WHERE u.active = 1 AND u.user_permis = 1";
        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1, $admin_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if($stmt->rowCount()==1&&$result['user_id']==$admin_id) return true; else return false;

    }

  }
  ?>