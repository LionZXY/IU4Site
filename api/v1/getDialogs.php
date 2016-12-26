<?php
include 'helpers/conn.php';
include 'helpers/dialogs.php';
include 'helpers/login.php';
$token = $_REQUEST['token'];

echo json_encode(array("status" => "sucs", "dialogs" => getDialogs($token, $conn)));
?>