<?php
include 'helpers/login.php';
include 'helpers/conn.php';
include 'helpers/dialogs.php';
header('Content-Type: application/json');
$token = $_REQUEST['token'];
$toUser = mysqli_escape_string($conn, $_REQUEST['toUser']);
$dialog = mysqli_escape_string($conn, $_REQUEST['dialog']);
$msg = mysqli_escape_string($conn, $_REQUEST['msg']);

$user = getUserFromToken($token, $conn);

if ($user['status'] != 'sucs')
    die(json_encode($user));


$sql = "INSERT INTO `message` (`msg`,`by_user`, `dialog_id`) VALUE ('$msg','" . $user['user_id'] . "','" . (!empty($dialog) ? $dialog : getDialogWithUser($toUser, $user['user_id'], $conn)) . "')";
$result = mysqli_query($conn, $sql);
if (!$result)
    die(json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn))));
else die(json_encode(array("status" => "sucs", "text" => "Сообщение успешно добавленна")));
?>