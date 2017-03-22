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
            <?php if(isset($validate_errors['refer_user_link_incorrect'])) {echo "<p style='color: red;'>Увага! Реферальне посилання некоректне!!!</p>";} ?>
            <?php if(isset($validate_errors['refer_user_link_not_found'])) {echo "<p style='color: red;'>Увага! Користувача з таким реферальним посиланням не існує!!!</p>";} ?>

            <?php if(isset($validate_errors['login_length'])) {echo "<p>Логін повинен бути щонайменш 3 символи</p>";} ?>
            <?php if(isset($validate_errors['login_exists'])) {echo "<p>Такий логін вже існує</p>";} ?>
            <p><input type="text" name="login" placeholder="login" value="<?php echo $login; ?>"></p>

            <?php if(isset($validate_errors['password_length'])) {echo "<p>Пароль повинен бути щонайменш 6 символів</p>";} ?>
            <p><input type="password" name="password" placeholder="password" value="<?php echo $password; ?>"></p>
            <?php if(isset($validate_errors['repeat_password'])) {echo "<p>Паролі не співпадають</p>";} ?>
            <p><input type="password" name="repeat_password" placeholder="repeat password"></p>

            <?php if (isset($refer_user[0]['login'])) echo "<p>Ви реєструєтесь по реферальному посиланню користувача  \"{$refer_user[0]['login']}\"</p>"; ?>

            <p><input type="submit" name="submit" value="Зареєструватись"></p>
        </form>

<?php  include_once (ROOT . '/views/layouts/footer.php')?>
