<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 20.03.2017
 * Time: 5:39
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($title)) echo $title; else echo 'Реферальна система'; ?></title>
</head>
<body>
<header>
    <a href="/">На головну</a>
    <span>||</span>
    <?php if (isset($_SESSION['user'])) : ?>
        <a href="/user/cabinet">Особистий кабінет</a>
        <span>||</span>
        <a href="/user/logout">Вихід</a>
        <hr>
        <p>Ви ввійшли як <b style="font-size: large;"><u> <?php echo $_SESSION['user']['login']; ?> </u></b></p>
        <hr>
    <?php else: ?>
        <a href="/user/login">Вхід</a>
        <span>||</span>
        <a href="/user/add">Реєстрація</a>
    <?php endif; ?>

</header>
