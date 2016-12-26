<?php
include 'helpers/conn.php';
include 'helpers/login.php';
$login = $_REQUEST['login'];
$password = $_REQUEST['password'];
echo loginIn($login, $password, $conn);


?>