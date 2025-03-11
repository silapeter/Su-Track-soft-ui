<?php
  class TypeDB {
    // DB Stuff
    private $conn;
    private $table = "change_type_db";
    private $doc_table = "change_project_doc";
    // private $money_type_table = "money_type";



    public $type_id;
    public $type_type;
    public $type_name;
    public $type_status;
    


    public function __construct($db) {
      $this->conn = $db;
    }


    
  public function type_master()
    {
        $output_array = array();
        $query = "select *, m.type_id as id, 'master_id' as master, m.type_name as name, m.type_status as status, 
                'text' as text , m.type_type as type  FROM $this->table m
                WHERE 1 ORDER BY m.type_name DESC";

        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($output_array, $result);
          }


          return  $output_array;
    }

      public function type_dropdown()
    {
        $output_array = array();
        $query = "select *, type_id as id, 'master_id' as master,type_name  as name, type_status as status, 
                'text' as text , type_type as type FROM $this->table 
                WHERE 1 ORDER BY type_index";

        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
             array_push($output_array,array("id" => "0000", "name" => "กรุณาเลือกประเภท", "type_id" => "0000"));   
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($output_array, $result);
          }


          return  $output_array;
    }

 public function save_type($saveMode)
    {

                if($saveMode == 'insert'){          

                        $query = "INSERT INTO $this->table (`type_type`, `type_name`, `type_status`,`type_id`) 
                        VALUES (?,?,?,?)";

                } else if($saveMode == 'update') {

                        $query = "UPDATE $this->table SET 
                        `type_type`= ? ,`type_name`= ?,`type_status`= ? 
                        WHERE  `type_id` = ? ";

                }
                        $stmt = $this->conn->prepare($query);


                                $stmt->bindParam(1, $this->type_type);
                                $stmt->bindParam(2, $this->type_name);
                                $stmt->bindParam(3, $this->type_status);
                                $stmt->bindParam(4, $this->type_id);

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

public function childCheck($id)
    {
        $query = "SELECT * FROM $this->doc_table d
                      WHERE d.type_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $type_am = $stmt->rowCount();
        
                if($type_am>0) return true; else return false;
    }

    public function del_type($id)
    {
                        $query = "DELETE FROM $this->table  
                        WHERE  `type_id` = ?";
                
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


  }
  ?>