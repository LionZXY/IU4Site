<?php

function loginIn($login, $password, $conn)
{
    if (!isset($login) || empty($login) || strlen($login) < 1)
        return (json_encode(array("status" => "err", "error_numb" => 1, "error_text" => "Логин не может быть пустым")));

    if (!isset($password) || empty($password))
        return (json_encode(array("status" => "err", "error_numb" => 2, "error_text" => "Пароль не может быть пустым")));


    if (strlen($login) > 256 || strlen($password) > 256)
        return (json_encode(array("status" => "err", "error_numb" => 4, "error_text" => "Максимальная длина логина, пароля и имени: 256")));

    if (!preg_match("/^([A-Za-z0-9]+)$/", $login))
        return (json_encode(array("status" => "err", "error_numb" => 5, "error_text" => "В логине пользователя можно использовать только символы латинского
алфавита")));
    else $password = md5($password);

    $sql = "SELECT * FROM `user` WHERE `login`='" . mysqli_escape_string($conn, $login) . "';";
    $result = mysqli_query($conn, $sql);
    if (!$result)
        return (json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn))));

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['password_md5'] == $password) {
            $token = randomString(50); //TODO Уникальность токена и перевод токена в число для последующей индексации в БД
            $sql = "INSERT INTO `tokens` (`login_id`,`token`, `permission`) VALUE ('" . $row['id'] . "', '" . mysqli_escape_string($conn, $token) . "','" . $row['permission'] . "')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                session_start();

                $_SESSION['token_id'] = mysqli_insert_id($conn);
                $_SESSION['token'] = $token;
                return (json_encode(array("status" => "sucs", "token" => $token)));
            } else return (json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn))));
        } else return (json_encode(array("status" => "err", "error_numb" => 8, "error_text" => "Пароль не верный")));
    } else return (json_encode(array("status" => "err", "error_numb" => 7, "error_text" => "Такого логина не существует")));
}

function getUserFromToken($token, $conn)
{
    session_start();
    if (!isset($token) || empty($token)) {
        if (session_status() != PHP_SESSION_NONE && isset($_SESSION['token_id']) && !empty($_SESSION['token_id'])) {
            $sql = "SELECT * FROM `tokens` WHERE `id` =" . $_SESSION['token_id'] . ";";
            $result = mysqli_query($conn, $sql);
            if (!$result)
                return array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn));
            else {
                if (mysqli_num_rows($result) <= 0)
                    return array("status" => "err", "error_numb" => 10, "error_text" => "Токен не найден");
                $row = mysqli_fetch_assoc($result);
                return array("status" => "sucs", "user_id" => $row['login_id'], "permission" => $row['permission']);
            }
        } else return array("status" => "err", "error_numb" => 13, "error_text" => "Отсутсвует обязательный токен");
    } else {
        $sql = "SELECT * FROM `tokens` WHERE `token` ='" . mysqli_escape_string($conn, $token) . "';";
        $result = mysqli_query($conn, $sql);
        if (!$result)
            return array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn));
        else {
            if (mysqli_num_rows($result) <= 0)
                return array("status" => "err", "error_numb" => 10, "error_text" => "Токен не верный");
            $row = mysqli_fetch_assoc($result);
            return array("status" => "sucs", "user_id" => $row['login_id'], "permission" => $row['permission']);
        }
    }
}

function randomString($length = 6)
{
    $str = "";
    $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

?>