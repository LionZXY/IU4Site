<?php
include 'helpers/conn.php';
include 'helpers/login.php';
$token = $_REQUEST['token'];
echo json_encode(getUserFromToken($token, $conn));
?>