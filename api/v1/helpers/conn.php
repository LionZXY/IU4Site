<?php
$servername = "localhost";
$username = "root";
$password = "159357za";
$dbname = "db_msg";

$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_set_charset($conn, 'utf8');
session_start();
?>