<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/user.php';


  $database = new Database();
  $db = $database->connect();

  $user_login = new User($db);
  $userName = $_GET['user_email'];
  $token = $_GET['token'];


    if($database->token == $token){
        $result = $user_login->_AdminLogin($userName);  
    } else {
      $result = array(
                       'error' => 'no token available or invalid token',     
                    );
    }

          echo json_encode($result);
?>

