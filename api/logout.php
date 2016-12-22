<?php
session_destroy();
die(json_encode(array("status" => "sucs", "text" => "Выход выполнен успешно")));
?>