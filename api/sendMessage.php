<?php
include 'login.php';
include 'conn.php';
$token = $_REQUEST['token'];
$toUser = mysqli_escape_string($conn, $_REQUEST['toUser']);
$msg = mysqli_escape_string($conn, $_REQUEST['msg']);
$user = getUserFromToken($token, $conn);

if ($user['status'] != 'sucs')
    die($user);

$sql = "INSERT INTO `message` (`msg`,`by_user`,`to_user`) VALUE ('$msg','" . $user['user_id'] . "','$toUser')";
$result = mysqli_query($conn, $sql);
if (!$result)
    die(json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn))));
else die(json_encode(array("status" => "sucs", "text" => "Сообщение успешно добавленна")));
?>