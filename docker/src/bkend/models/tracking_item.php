<?php

class itemDB {
    // DB Stuff
    private $conn;
    private $track_item = 'track_item';
    private $track_dept_db = 'track_dept_db';
    private $track_status = 'track_status';
    private $track_user = 'track_user';

    public $id_;
    public $caption_;
    public $detail_;
    public $owner_;
    public $date_;
    public $refer_;

    public function __construct( $db ) {
        $this->conn = $db;
    }

    public function get_track_details( $itemCode )
 {

        $query = "SELECT * FROM $this->track_item item
              LEFT JOIN $this->track_user u ON  item.iowner_ = u.user_email
              LEFT JOIN $this->track_dept_db d ON u.user_dept = d.dept_id 
              WHERE item.id_ = ?";
                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam( 1, $itemCode );
                $stmt->execute();
                $dataitem = $stmt->fetch( PDO::FETCH_ASSOC );


        $query = "SELECT * FROM $this->track_status st
              LEFT JOIN $this->track_user u ON  st.reciver_id = u.user_id
              LEFT JOIN $this->track_dept_db d ON u.user_dept = d.dept_id 
              WHERE st.track_id_ = ? 
              ORDER BY st.timestamp DESC";

        // $query = "SELECT * FROM $this->track_status st
    //           LEFT JOIN $this->track_item item ON   st.id_ = item.id_
    //           LEFT JOIN $this->track_user u ON  st.reciver_id = u.user_id
    //           LEFT JOIN $this->track_dept_db d ON u.user_dept = d.dept_id 
    //           WHERE st.track_id_ = ? 
    //           ORDER BY item.itimestamp DESC";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam( 1, $itemCode );
        $stmt->execute();

         $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $stmt->rowCount() > 0 ) {

            $row = array( 'result' => true,'detail' => $dataitem,'data' =>  $data  );
        } else {
            $row = array(
                'result' => false,
                'error' => "ไม่พบข้อมูลสำหรับรหัสติดตามที่ระบุ: $itemCode",
                'data' => []
            );
        }

        return $row;
    }

}

?>