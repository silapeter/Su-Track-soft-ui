<?php

header( 'Access-Control-Allow-Origin: *' );
// หรือกำหนดเฉพาะ Origin ที่ต้องการ
header( 'Access-Control-Allow-Methods: POST, OPTIONS' );
header( 'Access-Control-Allow-Headers: Content-Type, Authorization' );

header( 'Access-Control-Allow-Credentials: true' );

include_once '../../config/database.php';
include_once '../../models/user.php';

$database = new Database();
$db = $database->connect();

$usr = new User( $db );

// รับค่าจาก JSON Body ของ HTTP POST Request
$data = json_decode( file_get_contents( 'php://input' ) );

if ( !$data ) {
    echo json_encode( [ 'error' => 'Invalid JSON' ] );
    exit();
}

$usr->user_email = $data->email ?? null;
$usr->user_name  = $data->name ?? null;
$usr->user_surname = $data->phone ?? null;
$usr->user_text  =  $data->text ?? null;
$usr->active  =  0 ;
$usr->user_dept  =  "";
$usr->user_permis  =  "1";

$usr->user_id = uniqid();

$token = $data->token ?? '';

if ( $database->token == $token ) {
    $result = $usr->regis();
} else {
    $result = [
        'result' => $false,
        'error'  => 'ไม่สามารถบันทึกข้อมูลผู้ใช้ในฐานข้อมูลได้ กรุณาแจ้งผู้ดูแลระบบ: token Error'
    ];
}

echo json_encode( $result );
?>