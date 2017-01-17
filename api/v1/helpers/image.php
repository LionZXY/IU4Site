<?php
function queryRequest($type, $token, $conn, $avatar_id)
{
    $debug = false; //TODO switch to false
    $uploaddir = '/var/www/uploads/images/';
    if ($debug)
        ini_set('display_errors', 'On');
    if (!file_exists($uploaddir)) {
        if (!mkdir($uploaddir, 0775, true))
            return (json_encode(array("status" => "err", "error_numb" => 14, "error_text" => "Ошибка создания корневой папки")));
    }
    $user = getUserFromToken($token, $conn);
    if ($user['status'] != 'sucs')
        return json_encode($user);

    $folder_name = $uploaddir;

    switch ($type) {
        case 'avatar': {
            $folder_name .= 'avatar_' . $user['user_id'] . "/";
            $type = 1;
            break;
        }
        default:
            return (json_encode(array("status" => "err", "error_numb" => 17, "error_text" => "Неверный тип файла")));
    }

    if (!file_exists($folder_name) && !mkdir($folder_name, 0775, true))
        return (json_encode(array("status" => "err", "error_numb" => 14, "error_text" => "Ошибка создания папки")));

    if (!empty($_FILES) && file_exists($_FILES['image']['tmp_name'])) {
        if ($_FILES['image']['size'] > 2097152)
            return (json_encode(array("status" => "err", "error_numb" => 15, "error_text" => "Загружаемый файл слишком велик. Максимальный размер файла 2097152")));

        $format = ($_FILES['image']['type'] == "image/jpeg" ? 1 : 2);

        if (!($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/png"))
            return (json_encode(array("status" => "err", "error_numb" => 16, "error_text" => "Можно загружать только изображение png и jpeg")));
        $uploadfile = $folder_name . ('original'/*TODO Написать bash-скрипт для генерации изображения разных форматов*/) . ($format == 1 ?
                ".jpg" : ".png");
        if (file_exists($uploadfile))
            unlink($uploadfile);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
            $sql = "SELECT * FROM `image` WHERE `login_id` = " . $user['user_id'] . " AND `type` = 1;";
            $result = mysqli_query($conn, $sql);
            if (!$result)
                return json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn)));
            else if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO `image` (`login_id`, `type`, `permission`,`format`) VALUES (" . $user['user_id'] . ",$type," . $user['permission'] . "," . $format . ");";
                $result = mysqli_query($conn, $sql);
                if (!$result)
                    return json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn)));
            } else if (mysqli_fetch_assoc($result)['format'] != $format) {
                $sql = "UPDATE `image` SET `format` =" . $format . " WHERE `login_id` = " . $user['user_id'] . " AND `type` = 1;";
                $result = mysqli_query($conn, $sql);
                if (!$result)
                    return json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn)));
            }
            return (json_encode(array("status" => "sucs", "text" => "Изображение успешно загруженно")));
        } else return (json_encode(array("status" => "err", "error_numb" => 18, "error_text" => "Ошибка при загрузке файла")));
    } else {
        if ($type = 1) {
            if (!isset($avatar_id) || empty($avatar_id))
                $avatar_id = $user['user_id'];
            $folder_name = $uploaddir . 'avatar_' . $avatar_id . "/";
            $sql = "SELECT * FROM `image` WHERE `login_id` = " . $avatar_id . " AND `type` = 1;";
            $result = mysqli_query($conn, $sql);
            if (!$result)
                return json_encode(array("status" => "err", "error_numb" => 99, "error_text" => "Ошибка при запросе в БД: " . mysqli_error($conn)));
            $row = mysqli_fetch_assoc($result);
            if ($row['permission'] > $user['permission'])
                return json_encode(array("status" => "err", "error_numb" => 12, "error_text" => "Недостаточно прав"));
            $imageFile = $folder_name . "original" . ($row['format'] == 1 ?
                    ".jpg" : ".png");
            if (file_exists($imageFile)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename('avatar_' . $row['login_id'] . ($row['format'] == 1 ? ".jpg" : ".png")) . '"');
                header('Expires: 0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($imageFile));
                readfile($imageFile);
                exit;
            } else {
                $imageFile = "/var/www/html/source/image/default-avatar.png";
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="default-avatar.png"');
                header('Expires: 0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($imageFile));
                readfile($imageFile);
            }
            //return json_encode(array("status" => "err", "error_numb" => 18, "error_text" => "Запрашиваемый файл отсутсвует"));
        }
    }
}

?>
