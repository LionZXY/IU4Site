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
    <div class="product_v">
        <?php
        include 'conn.php';
        $comment_text = $_POST['comment_text'];
        $item_id = $_GET['item_id'];

        if (isset($item_id) && !empty($item_id)) {
            $item_id = mysqli_escape_string($conn, $item_id);
            if (isset($comment_text) && !empty($comment_text)) {
                if (!$isLogin)
                    die('У не зарегестрированных пользователей нет возможности оставлять комментарии');
                $comment_text = mysqli_escape_string($conn, $comment_text);
                $result = mysqli_query($conn, "INSERT INTO `comments` (`text`,`by_user`,`to_product`) VALUE ('$comment_text','" . getId($conn, $_SESSION['login']) . "','$item_id')");
                if (!$result)
                    mysqli_error($conn);
                else {
                    echo 'Комментарий добавлен успешно';
                }
            }
            $sql = "SELECT * FROM `items` WHERE `id`='$item_id';";
            $result = mysqli_query($conn, $sql);
            if (!$result)
                echo mysqli_error($conn);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<h1>", $row['title'], "</h1>";
                echo "<img src='", $row['image'], "'/>";
                echo "<p>", $row['descr'], "</p>";
            }
            $result = mysqli_query($conn, "SELECT * FROM `comments` WHERE `to_product`='$item_id' ORDER BY `time`;");

            if (!$result)
                echo mysqli_error($conn);

            if (mysqli_num_rows($result) > 0) {
                echo 'Комментарии:';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='comment'><div class='name'>", getName($conn, $row['by_user']), "</div>",
                    "<div class='comment_text'>", $row['text'], "</div></div>";
                }
            } else echo 'К этой записи ещё нет комментариев. Будь первым!';

            if ($isLogin) {
                echo '
        <form method="post" action="product.php?item_id=', $item_id, '">
<textarea rows="4" placeholder="Оставить комментарий" name="comment_text"></textarea>
            <input type="submit">
        </form>';
            }

        } else echo 'Отсуствует ID';


        function getName($conn, $id)
        {
            $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `id`='$id';");
            $name = mysqli_fetch_assoc($result)['name'];
            return empty($name) ? "Незвестный пользователь" : $name;
        }

        function getId($conn, $login)
        {
            $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `login`='$login';");
            return mysqli_fetch_assoc($result)['id'];
        }

        /*include 'conn.php';
        $result = mysqli_query($conn, "SELECT * FROM `items`;");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product">
            <img src="' . $row['image'] . '"/>
            <div class="title">' . $row['title'] . '</div>
            <div class="price">' . $row['price'] . '</div >
        </div > ';
            }
        } else echo mysqli_error($result);*/
        ?></div>
</div>
</body>
</html>