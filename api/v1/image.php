<?php
include 'helpers/login.php';
include 'helpers/conn.php';
include 'helpers/image.php';
$type = $_REQUEST['type'];
$avatar_id = $_REQUEST['avatar_id'];
$token = $_REQUEST['token'];
echo queryRequest($type, $token, $conn, $avatar_id);
if (file_exists($_FILES['image']['tmp_name']))
    unlink($_FILES['image']['tmp_name']);

?>