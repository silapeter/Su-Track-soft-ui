<?php
  class Fiscal {
    // DB Stuff
    private $conn;
    private $table = "change_fiscal_db";
    private $doc_table = "change_project_doc";



    public $fiscal_id;
    public $fiscal_year;
    public $fiscal_type;
    public $fiscal_name;
    public $fiscal_status;
    


    public function __construct($db) {
      $this->conn = $db;
    }


    
  public function fiscal_master()
    {
        $output_array = array();
        $query = "select *, fiscal_id as id, 'master_id' as master, CONCAT ('ปีงบประมาณ ' , fiscal_year, ' : ' , fiscal_name)  as name, fiscal_status as status, 
                'text' as text , fiscal_type as type FROM $this->table 
                WHERE 1 ORDER BY fiscal_year DESC";

        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($output_array, $result);
          }


          return  $output_array;
    }

    public function get_current()
    {

        $query = "select *, fiscal_id as id, 'master_id' as master, CONCAT ('ปีงบประมาณ ' , fiscal_year, ' : ' , fiscal_name)  as name, fiscal_status as status, 
                'text' as text , fiscal_type as type FROM $this->table 
                WHERE fiscal_status ORDER BY fiscal_year DESC";

        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $current_fiscal = $result['name'];
          }

                $result = array(
                                'result' => $current_fiscal,
                                'error' => '$errTxt',     
                                );
          return  $result;
    }

        public function get_current_details()
    {

        $query = "select *, fiscal_id as id, 'master_id' as master, CONCAT ('ปีงบประมาณ พ.ศ.' , fiscal_year, ' : ' , fiscal_name)  as name, fiscal_status as status, 
                'text' as text , fiscal_type as type FROM $this->table 
                WHERE fiscal_status ORDER BY fiscal_year DESC";

        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        
        // while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //      array_push($output_array, $result);
        // }

          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $current_fiscal_name = $result['name'];
             $current_fiscal_year = $result['fiscal_year'];
             $current_fiscal_id = $result['fiscal_id'];
          }

                $result = array(
                                'current_name' => $current_fiscal_name,
                                'current_year' => $current_fiscal_year,
                                'current_id' => $current_fiscal_id,
                                'error' => '$errTxt',     
                                );
          return  $result;
    }

      public function fiscal_dropdown($id)
    {
        $output_array = array();
        $query = "select *, fiscal_id as id, 'master_id' as master, CONCAT ('ปีงบประมาณ ' , fiscal_year, ' : ' , fiscal_name)  as name, fiscal_status as status, 
                'text' as text , fiscal_type as type FROM $this->table 
                WHERE fiscal_id != '$id' ORDER BY fiscal_year DESC";

        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
             array_push($output_array,array("id" => "0000", "name" => "กรุณาเลือกปีงบประมาณปลายทาง", "fiscal_id" => "0000"));   
          while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
             array_push($output_array, $result);
          }


          return  $output_array;
    }

 public function save_fiscal($saveMode)
    {
        // ถ้าสถานะที่ส่งเข้ามาเป็น 1 ให้ปรับทุกตัวเป็น 0 ก่อน เพราะมี 1 ได้แค่ record เดียว
                if($this->fiscal_status==1){
                        $stmt = $this->conn->prepare("UPDATE $this->table SET `fiscal_status`= 0 WHERE 1");

                        try{
                                $stmt->execute();
                        }
                         catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถบันทึกข้อมูลในฐานข้อมูลได้: Api Error cannot update status of $this->table" . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );
                                return $result;
                        }  
                }

                if($saveMode == 'insert'){          

                        $query = "INSERT INTO $this->table (`fiscal_year`, 
                        `fiscal_type`, `fiscal_name`, `fiscal_status`,`fiscal_id`) 
                        VALUES (?,?,?,?,?)";

                } else if($saveMode == 'update') {

                        $query = "UPDATE $this->table SET `fiscal_year`= ? ,
                        `fiscal_type`= ? ,`fiscal_name`= ?,`fiscal_status`= ? 
                        WHERE  `fiscal_id` = ? ";

                }
                        $stmt = $this->conn->prepare($query);

                                $stmt->bindParam(1, $this->fiscal_year);
                                $stmt->bindParam(2, $this->fiscal_type);
                                $stmt->bindParam(3, $this->fiscal_name);
                                $stmt->bindParam(4, $this->fiscal_status);
                                $stmt->bindParam(5, $this->fiscal_id);

                try {

                $stmt->execute();
                        //success
                        $errTxt = $this->fiscal_id ;
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
                      WHERE d.fiscal_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $fiscal_am = $stmt->rowCount();
        
                if($fiscal_am>0) return true; else return false;
    }

    public function del_fiscal($id)
    {
                        $query = "DELETE FROM $this->table  
                        WHERE  `fiscal_id` = ?";
                
                        $stmt = $this->conn->prepare($query);
                                $stmt->bindParam(1, $id);
                try {
                $stmt->execute();
                        //success
                        $errTxt = "";
                        $result = array(
                        'result' => true,
                        'error' => $errTxt,     
                    );
                }
                catch (PDOException $e) {
                        //error
                        $errTxt = "ไม่สามารถลบข้อมูลในฐานข้อมูลได้: API error : fiscal_table" . $e->getMessage();
                                $result = array(
                                'result' => false,
                                'error' => $errTxt,     
                        );

                }

                return $result;
        }


  }
  ?>