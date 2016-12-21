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
    <form action="add.php" method="post" class="add_form"
          style="<?php echo isset($_POST['title']) ? "display: none" : "" ?> ">
        <input name="title" type="text" placeholder="Название продукта"/>
        <input name="image" type="text" placeholder="Ссылка на изображение"/>
        <input name="price" type="number" placeholder="Цена"/>
        <textarea rows="20" placeholder="Описание" name="descr"></textarea>
        <input type="submit">
    </form>
    <?php
    $title = $_POST['title'];
    if (isset($title) && !empty($title)) {
        if (!$isLogin)
            die('Вы не авторизованны');
        if ($permission < 11)
            die('У вас нет прав. Если вы считаете, что это ошибка, попробуйте перезайти или обратитесь к администратору');
        include 'conn.php';

        $sql = "SELECT * FROM `users` WHERE `login` ='" . mysqli_escape_string($conn, $_SESSION['login']) . "';";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) <= 0)
            die('Несуществует такого логина');
        else $id = mysqli_fetch_assoc($result)['id'];

        $title = mysqli_escape_string($conn, $title);
        $image = mysqli_escape_string($conn, $_POST['image']);
        $price = mysqli_escape_string($conn, $_POST['price']);
        $descr = mysqli_escape_string($conn, $_POST['descr']);

        $sql = "INSERT INTO `items` (`title`,`by_user`,`descr`,`price`,`image`) VALUE
('$title', '$id','$descr','$price','$image');";

        if (mysqli_query($conn, $sql))
            echo 'Товар "', $title, '" успешно добавлен';
        else echo mysqli_error($conn);

    }
    ?>
</div>
</body>
</html>