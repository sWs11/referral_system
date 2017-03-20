<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 20.03.2017
 * Time: 3:57
 */
?>
<?php  include_once (ROOT . '/views/layouts/header.php')?>
<h1>login</h1>

<form action="" method="post">
    <form action="" method="post">
        <!--        $validate_errors['login_length']-->
        <?php if(isset($validate_errors['user_does_not_exist'])) {echo "<p>Введено невірний логін або пароль</p>";} ?>
        <p><input type="text" name="login" placeholder="login" value="<?php echo $login; ?>"></p>
        <p><input type="password" name="password" placeholder="password" value="<?php echo $password; ?>"></p>

        <p><a href="/user/add">add acount</a></p>

        <p><input type="submit" name="submit" value="login"></p>
    </form>
</form>
<?php  include_once (ROOT . '/views/layouts/footer.php')?>