<?php
include 'helpers/conn.php';
$name = $_REQUEST['name'];
$login = $_REQUEST['login'];
$password = $_REQUEST['password'];

if (!isset($login) || empty($login))
    die(json_encode(array("status" => "err", "error_numb" => 1, "error_text" => "Логин не может быть пустым")));

if (!isset($password) || empty($password))
    die(json_encode(array("status" => "err", "error_numb" => 2, "error_text" => "Пароль не может быть пустым")));

if (!isset($name) || empty($name))
    die(json_encode(array("status" => "err", "error_numb" => 3, "error_text" => "Имя не может быть пустым")));

if (strlen($login) > 256 || strlen($name) > 256 || strlen($password) > 256)
    die(json_encode(array("status" => "err", "error_numb" => 4, "error_text" => "Максимальная длина логина, пароля и имени: 256")));

if (!preg_match("/^([A-Za-z0-9]+)$/", $login))
    die(json_encode(array("status" => "err", "error_numb" => 5, "error_text" => "В логине пользователя можно использовать только символы латинского     алфавита")));

//TODO if (!preg_match("/^([А-Яа-яA-Za-z]+ [А-Яа-яA-Za-z]+)$/", $name))
//    die(json_encode(array("status" => "err", "error_numb" => 9, "error_text" => "Имя должно состоять из двух слов. В словах должны быть только буквы русского и латинского алфавита")));
else $password_md5 = md5($password);


if (!loginAndEmailIsValid($login, $conn))
    die(json_encode(array("status" => "err", "error_numb" => 6, "error_text" => "Такой логин уже зарегестрированн в системе")));

$login = mysqli_escape_string($conn, $login);
$sql = "INSERT INTO `user` (`login`,`password_md5`, `name`) VALUE
('$login', '$password_md5','" . mysqli_escape_string($conn, $name) . "');";
if (mysqli_query($conn, $sql)) {
    include 'helpers/login.php';
    include 'helpers/image.php';
    $login = loginIn($login, $password, $conn);
    if (json_encode($login)['status'] == 'sucs' && array_key_exists("image", $_FILES))
        queryRequest("avatar", null, $conn, null);
    die($login);
} else die (json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn))));


function loginAndEmailIsValid($login, $conn)
{
    $sql = "SELECT * FROM `user` WHERE `login` ='" . mysqli_escape_string($conn, $login) . "';";
    $result = mysqli_query($conn, $sql);
    if (!$result)
        return true;
    if (mysqli_num_rows($result) > 0)
        return false;
    else return true;
} ?>