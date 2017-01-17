<?php
include 'api/v1/helpers/conn.php';
include 'api/v1/helpers/dialogs.php';
include 'api/v1/helpers/login.php';
include 'api/v1/helpers/getUser.php';

$dialogs = getDialogs(null, $conn);
?>

<div class="dialogs_head">
      <div class="dialogs_add"></div>
</div>

<div class="events">
    <?php
    foreach ($dialogs as $dialog) {
        echo '<div data-row="' . $dialog['id'] . '" class="events_card">
        <img class="round_ava" src="api/v1/image.php?type=avatar&avatar_id="' . $dialog['by_user'] . '/>
        <div class="events_texts">
            <div class="title_box">
                <div class="events_title">' . getUser($dialog['by_user'], $conn)['name'] . '</div>
                <div class="events_time">' . getNormalDate($dialog['time']) . '</div>
            </div>
            <div class="events_text">' . $dialog['msg'] . '</div>
        </div>
    </div>';
    }
    ?>

</div>
<div class="vertical-line"></div>
<?php
function getNormalDate($str)
{
    $timestamp = strtotime($str);
    $now = time();
    $dayFromUnix = (int)($now / 86400);
    $dayTime = (int)($timestamp / 86400);

    if ($dayFromUnix == $dayTime)
        return date("H:i", $timestamp);
    elseif ($dayFromUnix - $dayTime == 1)
        return "вчера";
    else return date("j F");
} ?>

<script src="js/messages.js"></script>
