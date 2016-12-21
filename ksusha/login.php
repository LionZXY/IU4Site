<html>
<head>
    <title>Магазин моих вещей | Войти</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>">
</head>
<body>
<div class="head">

</div>
<div class="menu_left">
    <a href="login.php">Войти</a>
    <a href="register.php">Регистрация</a>
    <a href="/\">Продукты</a>
    <?php if (session_status() == PHP_SESSION_NONE) session_start();
    $isLogin = isset($_SESSION['login']) && !empty($_SESSION['login']);
    $permission = $_SESSION['perm'];
    if ($isLogin && $permission > 10)
        echo "<a href='add.php'>Добавить продукт</a>" ?>
</div>
<div class="content">
    <form action="login.php" method="post" style="<?php echo isset($_POST['login']) ? "display: none" : "" ?> ">
        <input type="text" name="login" placeholder="Логин"/>
        <input type="password" name="password" placeholder="Пароль"/>
        <input type="submit">
    </form>
    <?php
    if (isset($_POST['login'])) {
        include 'conn.php';

        $login = $_POST['login'];
        $password = $_POST['password'];
        if (empty($login))
            die('Логин не может быть пустым!');
        if (strlen($login) > 256 || strlen($password) > 256)
            die('Максимальная длина логина, пароля и имени: 256');
        if (!preg_match("/^([A-Za-z0-9]+)$/", $login))
            die('В логине пользователя можно использовать только символы латинского
алфавита');
        if (empty($password))
            die('Пароль не может быть пустым!');
        else $password = md5($password);

        $sql = "SELECT * FROM `users` WHERE `login` ='" . mysqli_escape_string($conn, $login) . "';";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) <= 0)
            die('Несуществует такого логина');
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] == $password) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['login'] = $row['login'];
            $_SESSION['perm'] = $row['perm'];
            echo 'Авторизация прошла успешно!';
        } else echo 'Неправильный пароль';
    }


    ?>
</div>
</body>
</html>