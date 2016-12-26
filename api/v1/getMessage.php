<?php
include 'helpers/login.php';
include 'helpers/conn.php';
include 'helpers/dialogs.php';
$token = $_REQUEST['token'];
$dialog = $_REQUEST['dialog'];

echo json_encode(getMessage($dialog, $token, $conn));

?>