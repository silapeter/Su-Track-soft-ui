<?php
  class SysDB {
    // DB Stuff
    private $conn;
    private $table = "change_system_db";
    // private $doc_table = "change_project_doc";
    // private $money_type_table = "money_type";



    public $s_id;
    public $s_key;
    public $s_value;

    


    public function __construct($db) {
      $this->conn = $db;
    }


    
  public function get_s($k)
    {
        $output_array = array();
        $query = "select *  FROM $this->table s
                WHERE `s_key` = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $k);
  
        $stmt->execute();
        
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = array(
                        's_key' => $result["s_key"],
                        's_value' => $result["s_value"],     
                        );

          return  $result;
    }

 public function save_s($k,$v)
    {


                        $query = "UPDATE $this->table SET  `s_value`= ?  WHERE  `s_key` = ? ";

                        $stmt = $this->conn->prepare($query);

                                $stmt->bindParam(1, $v);
                                $stmt->bindParam(2, $k);

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


  }
  ?>