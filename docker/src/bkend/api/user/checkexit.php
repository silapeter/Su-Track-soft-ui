<?php 
header("Access-Control-Allow-Origin: *"); // หรือกำหนดเฉพาะ Origin ที่ต้องการ
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Access-Control-Allow-Credentials: true");

  include_once '../../config/database.php';
  include_once '../../models/user.php';


  $database = new Database();
  $db = $database->connect();

  $user_table = new User($db);
  $email = $_GET['email'];
  $token = $_GET['token'];


    if($database->token == $token){
        $result = $user_table->_check_exit_email($email);  
    } else {
      $result = array(
                       'error' => 'no token available or invalid token',     
                    );
    }

          echo json_encode($result);
?>

