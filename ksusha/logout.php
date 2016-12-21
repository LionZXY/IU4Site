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
    <?php
    echo 'Вы вышли';
    session_destroy();
    ?>
</div>
</body>
</html>