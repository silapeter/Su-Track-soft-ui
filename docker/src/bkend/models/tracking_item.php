<?php
  class itemDB {
    // DB Stuff
    private $conn;
    private $track_item = "track_item";
    private $track_dept_db = "track_dept_db";
    private $track_status = "track_status";
    private $track_user = "track_user";



    public $id_;
    public $caption_;
    public $detail_;
    public $owner_;
    public $date_;
    public $refer_;


    public function __construct($db) {
      $this->conn = $db;
    }
    

public function get_track_details($itemCode)
{
    $query = "SELECT * FROM $this->track_status st
              LEFT JOIN $this->track_item item ON item.id_ = st.id_
              LEFT JOIN $this->track_user u ON u.user_id = st.reciver_id
              LEFT JOIN $this->track_dept_db d ON d.dept_id = u.user_dept
              WHERE st.track_id_ = ? 
              ORDER BY item.timestamp DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $itemCode);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $row = array("result" => true, "data" => $data);
    } else {
        $row = array(
            "result" => false,
            "error" => "ไม่พบข้อมูลสำหรับรหัสติดตามที่ระบุ: $itemCode",
            "data" => []
        );
    }

    return $row;
}





  }

  ?>