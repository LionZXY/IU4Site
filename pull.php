<?php
/**
 * Created by PhpStorm.
 * User: lionzxy
 * Date: 08.01.17
 * Time: 19:51
 */
ini_set('display_errors', '1');
define('PRIVATE_KEY', 'vZc{P)[v7v?A:u4}cj9$<Q}bCtdL:%Qn\'SL9EcBjn)HTV5++Kp');
require(__DIR__ . "/vendor/autoload.php");

use GitHubWebhook\Handler;

$handler = new Handler(PRIVATE_KEY, __DIR__. "/IU4-13");
if($handler->handle()) {
    echo "OK";
} else {
    echo "Wrong secret";
}
?>