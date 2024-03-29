<?php session_start();
$isLogin = isset($_SESSION['token_id']) && !empty($_SESSION['token_id']) && $_SESSION['token_id'] > 0; ?>
<html>
<head><title>Главная страница</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles/head.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/burger.css">
    <link rel="stylesheet" type="text/css" href="styles/menu.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/card.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/notify.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/index.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/events.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/login/material_input_text.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/messages.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/login/login.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/login/button.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/login/material_input_file.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="styles/loader.css?<?php echo time(); ?>">

    <link rel="apple-touch-icon" sizes="57x57" href="/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
    <link rel="manifest" href="/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script src="js/index.js"></script>
</head>
<body>
<div>
    <?php
    include 'head.php'
    ?></div>
<div class="main">
    <?php
    if ($isLogin)
        include "events.php";
    ?>
    <div class="message_box">
        <?php //include 'message.php'?>
    </div>

    <script src="js/messages.js"></script>
</div>
<?php
if (!$isLogin)
    include 'login.php';
?>
</body>
</html>
