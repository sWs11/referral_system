<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 15:41
 */

include_once(ROOT . '/models/Users.php');

class UsersController
{
    public function actionAdd () {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                echo 'NU ok';
            }
        }

        $result = Users::addUser();

//        echo $result;

//        var_dump($_SERVER['REQUEST_METHOD']);

        require_once(ROOT . '/views/users/add.php');

        return true;
    }
}