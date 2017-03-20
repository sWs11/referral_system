<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 15:57
 */

?>
<?php  include_once (ROOT . '/views/layouts/header.php')?>

        <h1>Add new user</h1>
        <form action="" method="post">
            <!--        $validate_errors['login_length']-->
            <?php if(isset($validate_errors['login_length'])) {echo "<p>Логін повинен бути щонайменш 3 символи</p>";} ?>
            <?php if(isset($validate_errors['login_exists'])) {echo "<p>Такий логін вже існує</p>";} ?>
            <p><input type="text" name="login" placeholder="login" value="<?php echo $login; ?>"></p>
            <!--        <input type="email" name="email" placeholder="email">-->
            <?php if(isset($validate_errors['password_length'])) {echo "<p>Пароль повинен бути щонайменш 6 символів</p>";} ?>
            <p><input type="password" name="password" placeholder="password" value="<?php echo $password; ?>"></p>
            <?php if(isset($validate_errors['repeat_password'])) {echo "<p>Паролі не співпадають</p>";} ?>
            <p><input type="password" name="repeat_password" placeholder="repeat password"></p>

            <p><a href="/user/login">login</a></p>

            <p><input type="submit" name="submit" value="add"></p>
        </form>

<?php  include_once (ROOT . '/views/layouts/footer.php')?>
