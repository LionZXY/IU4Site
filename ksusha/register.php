<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$isLogin = isset($_SESSION['login']) && !empty($_SESSION['login']);
$permission = $_SESSION['perm']; ?>
<html>
<head>
    <title>Магазин моих вещей | Продукты</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>">
</head>
<body>
<div class="head">

</div>
<div class="menu_left">
    <?php
    if (!$isLogin)
        echo '<a href="login.php">Войти</a>
    <a href="register.php">Регистрация</a>';
    else echo '<a href="logout.php">Выйти</a>';
    ?>
    <a href="index.php">Продукты</a>
    <?php
    if ($isLogin && $permission > 10)
        echo "<a href='add.php'>Добавить продукт</a>" ?>
</div>
<div class="content">
    <form action="register.php" method="post" style="<?php echo isset($_POST['login']) ? "display: none" : "" ?> ">
        <input type="text" name="name" placeholder="Имя"/>
        <input type="text" name="login" placeholder="Логин"/>
        <input type="password" name="password" placeholder="Пароль"/>
        <input type="submit">
    </form>
    <?php
    if (isset($_POST['login'])) {
        include 'conn.php';

        $login = $_POST['login'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        if (empty($login))
            die('Логин не может быть пустым!');
        if (strlen($login) > 256 || strlen($name) > 256 || strlen($password) > 256)
            die('Максимальная длина логина, пароля и имени: 256');
        if (!preg_match("/^([A-Za-z0-9]+)$/", $login))
            die('В логине пользователя можно использовать только символы латинского
алфавита');
        if (empty($password))
            die('Пароль не может быть пустым!');
        else $password = md5($password);
        if (!loginAndEmailIsValid($login, $conn))
            die('Такой логин уже зарегестрированн в системе');
        $sql = "INSERT INTO `users` (`login`,`password`, `name`) VALUE
('$login', '$password','" . mysqli_escape_string($conn, $name) . "');";
        if (mysqli_query($conn, $sql)) {
            echo 'Регистрация прошла успешно';
            $_SESSION['login'] = $login;
            $_SESSION['name'] = $name;
        } else echo mysqli_error($conn);

    }

    function loginAndEmailIsValid($login, $conn)
    {
        $sql = "SELECT * FROM `users` WHERE `login` ='" . mysqli_escape_string($conn, $login) . "';";
        $result = mysqli_query($conn, $sql);
        if (!$result)
            return true;
        if (mysqli_num_rows($result) > 0)
            return false;
        else return true;
    }


    ?>
</div>
</body>
</html>