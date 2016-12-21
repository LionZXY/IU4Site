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
    <a href="login.php">Войти</a>
    <a href="register.php">Регистрация</a>
    <a href="/">Продукты</a>
    <?php if (session_status() == PHP_SESSION_NONE) session_start();
    $isLogin = isset($_SESSION['login']) && !empty($_SESSION['login']);
    $permission = $_SESSION['perm'];
    if ($isLogin && $permission > 10)
        echo "<a href='add.php'>Добавить продукт</a>" ?>
</div>
<div class="content">
    <?php
    include 'conn.php';
    $result = mysqli_query($conn, "SELECT * FROM `items`;");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a class="product" href="product.php?item_id=' . $row['id'] . '">
        <img src="' . $row['image'] . '"/>
        <div class="title">' . $row['title'] . '</div>
        <div class="price">' . $row['price'] . '</div >
    </a > ';
        }
    } else echo mysqli_error($result);
    ?>
</div>
</body>
</html>