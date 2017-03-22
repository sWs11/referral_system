<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 20.03.2017
 * Time: 4:56
 */
?>
<?php  include_once (ROOT . '/views/layouts/header.php')?>
<?php //var_dump($data); ?>
<h1>Особистий кабінет</h1>
<hr>

<?php
if (isset($result_pay)) {
    if ($result_pay) {
        echo "<h3>Поповнення балансу пройшло успішно!</h3>";
    } else {
        echo "<h3>Відбулась помилка при поповненні балансу!</h3>";
    }
}
?>

<form action="" method="post">
    <h3>Поповнити баланс</h3>
    <?php if (isset($validate_errors['less_than_zero'])) echo "<p>Сума платежу повинна більше нуля!</p>"; ?>
    <input type="number" placeholder="Сума платежу" name="pay">
    <input type="submit" name="submit" value="Поповнити">
</form>

<hr>

<!--    <p><span>Login: </span><span> --><?php //echo Common::$dataUser['login']?><!--</span></p>-->
<p>Логін: <?php echo $data['user_data']['login']; ?></p>
<p>Баланс: <?php echo $data['user_data']['balance']; ?></p>
<!--    <p>Реферальне посилання: --><?php //echo "http://{$_SERVER['SERVER_NAME']}/user/add/{$user_data['referral_link']}"; ?><!--</p>-->
<p>Реферальне посилання: <a href="<?php echo "http://{$_SERVER['SERVER_NAME']}/user/add/{$data['user_data']['referral_link']}" ?>"><?php echo "http://{$_SERVER['SERVER_NAME']}/user/add/{$data['user_data']['referral_link']}" ?></a></p>
<?php if (isset($data['user_data']['refer_id'])) : ?>
    <p>Рефер: <?php echo $data['refer_login']; ?></p>
<?php endif; ?>

<h3>Ваші реферали:</h3>
<ul>
    <?php foreach ($data['referrals_data'] as $referral_user) : ?>

        <li><?php echo "{$referral_user['login']}" ?></li>

    <?php endforeach; ?>
</ul>

<?php  include_once (ROOT . '/views/layouts/footer.php')?>
