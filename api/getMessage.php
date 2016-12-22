<?php
include 'login.php';
include 'conn.php';
$token = $_REQUEST['token'];
$byUser = $_REQUEST['byUser'];
$toUser = $_REQUEST['toUser'];
$user = getUserFromToken($token, $conn);

if ($user['status'] != 'sucs')
    die($user);
$sql = null;
if (empty($byUser) && !empty($toUser)) {
    $sql = "SELECT * FROM `tokens` WHERE `by_user` ='" . $user['user_id'] . "' AND `to_user` = '" . mysqli_escape_string($conn, $toUser) . "';";
} else if (!empty($byUser) && empty($toUser)) {
    $sql = "SELECT * FROM `tokens` WHERE `to_user` ='" . $user['user_id'] . "' AND `by_user` = '" . mysqli_escape_string($conn, $byUser) . "';";
} else if (!empty($byUser) && !empty($toUser)) {
    if ($user['permission'] > 99)
        $sql = "SELECT * FROM `tokens` WHERE `to_user` ='" . mysqli_escape_string($conn, $toUser) . "' AND `by_user` = '" . mysqli_escape_string($conn, $byUser) . "';";
    else die(json_encode(array("status" => "err", "error_numb" => 12, "error_text" => "Недостаточно прав")));

}

if ($sql == null)
    die(json_encode(array("status" => "err", "error_numb" => 11, "error_text" => "Неправильный запрос. Возможно только получить исходящие сообщения, входящие, и, если вы админ (права 100 и выше), можно получить сообщения от одного пользователя другому пользователю")));

$result = mysqli_query($conn, $sql);
if (!$result)
    die(json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn))));

$messages = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($messages, $row);
}

echo json_encode(array("status" => "sucs", "messages" => $messages));
?>