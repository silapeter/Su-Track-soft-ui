<?php 
   header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/user.php';


  $database = new Database();
  $db = $database->connect();

  $usr = new User($db);
  $usr->user_email = $_GET['user_email'];
  $usr->user_name = $_GET['user_name'];
  $usr->user_surname = $_GET['user_surname'];
  $usr->user_text = $_GET['user_text'];
  $token = $_GET['token'];


    if($database->token == $token){
        $result = $usr->profile_update();  
    } else {
      $result = array(
                       'error' => 'no token available or invalid token',     
                    );
    }

          echo json_encode($result);
?>