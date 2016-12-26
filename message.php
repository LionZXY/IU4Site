<?php
include_once "api/v1/helpers/dialogs.php";
include_once "api/v1/helpers/conn.php";
include_once "api/v1/helpers/login.php";

try {
    $message = getMessage($_REQUEST['dialog'], $_REQUEST['token'], $conn);
} catch (Exception $exception) {
    die($exception);
}
if ($message['status'] == 'sucs') {
    $message = $message['messages'];
} else {
    die(json_encode($message));
}//TODO

?>
<form id="sendMessage" onsubmit="return sendMessage(<?php echo $_REQUEST['dialog'] ?>);">
    <div class="input">
        <div class="plus"></div>
        <input type="text" placeholder="Введите текст сообщения">
        <input type="submit" value="" class="send"></input>
    </div>
</form>
<div class="messages">
    <?php
    $userid = getUserFromToken(null, $conn)['user_id'];
    for ($i = count($message) - 1; $i > -1; $i--) {
        $first = $message[$i]['by_user'] != $message[$i - 1]['by_user'];
        echo '<div class="m ' . ($userid == $message[$i]['by_user'] ? 'm_to' : 'm_from') . '">' .
            ($first ? '<img src="/api/v1/image.php?type=avatar&avatar_id=' . $message[$i]['by_user'] . '"/>' : '') . '
        <div class="' . ($first ? 'first' : '') . '">' . $message[$i]['msg'] . '</div>
    </div>';
    }
    ?>
</div>
