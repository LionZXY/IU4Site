<?php
function getDialogs($token, $conn)
{
    $user = getUserFromToken($token, $conn);

    if ($user['status'] != 'sucs')
        return ($user);

    $userid = $user['user_id'];
    $sql = "SELECT dial.`id`, mess.`time`, mess.`msg`, mess.`by_user` FROM (SELECT * FROM `dialogs` WHERE `user1` = $userid OR `user2` = $userid) AS dial,(SELECT * FROM `message`
WHERE `time` = (SELECT MAX(`time`) FROM `message` AS m WHERE m.`dialog_id` = `message`.`dialog_id`)) AS mess WHERE dial.`id` = mess.`dialog_id` ORDER BY mess.`time` DESC;";

    $result = mysqli_query($conn, $sql);
    if (!$result)
        return array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn));

    $dialogs = array();


    while ($row = mysqli_fetch_assoc($result)) {
        array_push($dialogs, $row);
    }

    return $dialogs;
}

function getDialogWithUser($user_id, $toUser, $conn)
{
    $sql = "SELECT * FROM `dialogs` WHERE (`user1` = $user_id AND `user2` = $toUser) OR (`user2` = $user_id AND `user1` = $toUser);";
    $result = mysqli_query($conn, $sql);
    if (!$result)
        return array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn));
    elseif (mysqli_num_rows($result) > 0)
        return mysqli_fetch_assoc($result)['id'];
    else {
        $sql = "INSERT INTO `dialogs` (`user1`,`user2`) VALUE ($user_id,$toUser);";
        $result = mysqli_query($conn, $sql);
        if (!$result)
            return array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn));
        else return mysqli_insert_id($conn);
    }
}

function getMessage($dialog, $token, $conn)
{

    $dialog = mysqli_escape_string($conn, $dialog);
    $user = getUserFromToken($token, $conn);
    //TODO оптимизировать!
    if ($user['status'] != 'sucs')
        return ($user);
    $userid = $user['user_id'];
    $sql = "SELECT * FROM `dialogs` WHERE `id` = '$dialog' AND (`user1` = '$userid' OR `user2` = '$userid')";
    $result = mysqli_query($conn, $sql);
    if (!$result)
        return array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn));
    if (mysqli_num_rows($result) == 0)
        return array("status" => "err", "error_numb" => 12, "error_text" => "Недостаточно прав");

    $sql = "SELECT * FROM `message` WHERE `dialog_id` = '" . mysqli_escape_string($conn, $dialog) . "';";
    $result = mysqli_query($conn, $sql);
    if (!$result)
        return (array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn)));

    $messages = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($messages, $row);
    }

    return array("status" => "sucs", "messages" => $messages);
}

?>