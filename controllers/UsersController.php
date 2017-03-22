<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 15:41
 */

include_once(ROOT . '/models/Users.php');

/**
 * Class UsersController
 */
class UsersController
{
    public function actionIndex () {
        return true;
    }

    private function loginUser ($user_data) {
//        var_dump($user_data);
        // Записуємо дані користувача в сессію щоб мати
        // доступ до них на будь-якій сторінці сайту
        $_SESSION['user']['id'] = $user_data['id'];
        $_SESSION['user']['login'] = $user_data['login'];
        $_SESSION['user']['referral_link'] = $user_data['referral_link'];
        $_SESSION['user']['refer_id'] = $user_data['refer_id'];



//        var_dump($_SESSION);
        header('Location: /user/cabinet');
//        header();
    }

    public function actionLogin () {

        //Якщо користувач залогінений, то перенаправити в особистий кабінет
        Common::checkLoginUser();

        $title = 'Вхід';
        $login = '';
        $password ='';
        $validate_errors = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['submit']) && !empty($_POST['login']) && !empty($_POST['password'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];

                $user_data = Users::checkLoginExists($login, md5($password));

                if($user_data) {
                    $this->loginUser($user_data[0]);
                } else {
                    $validate_errors['user_does_not_exist'] = false;
                }
            }
        }

        require_once(ROOT . '/views/users/login.php');
        return true;
    }

    public function actionLogout () {
        unset($_SESSION['user']);
        header("Location: /");
    }

    public function actionAdd ($parameters = null) {
        Common::checkLoginUser();

        $title = 'Реєстрація';

        $login ='';
        $password ='';
        $refer_id = null;
        $validate_errors = [];

        /*echo "<br><br> parameters";
        var_dump($parameters);*/

        if ($parameters) {
            if (!preg_match('~\W+~', $parameters[0])) {
                $refer_user = Users::checkReferralLink($parameters[0]);

                if (count($refer_user) > 0) {
                    $refer_id = $refer_user[0]['id'];
                } else {
                    $validate_errors['refer_user_link_not_found'] = false;
                }
            } else {
                $validate_errors['refer_user_link_incorrect'] = false;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if (isset($_POST['submit']) && !empty($_POST['login']) && !empty($_POST['password'])) {

                $login = $_POST['login'];
                $password = $_POST['password'];
                $repeat_password = $_POST['repeat_password'];
                $referral_link = hash("md5", $login);

                if(mb_strlen($login) < 3) {
                    $validate_errors['login_length'] = false ;
                }

                if(mb_strlen($password) < 6) {
                    $validate_errors['password_length'] = false;
                }

                if($password != $repeat_password) {
                    $validate_errors['repeat_password'] = false;
                }

                if(Users::checkLoginExists($login)) {
                    $validate_errors['login_exists'] = false;
                }

                if (count($validate_errors) == 0) {
                    $result = Users::addUser(htmlspecialchars($login), md5($password), $referral_link, $refer_id);
                    //Якщо реєстрація пройшла успішно, юзера одразу й залогінить
                    if ($result) {
                        $this->actionLogin();
                    }
                }
            }
        }

        require_once(ROOT . '/views/users/add.php');

        return true;
    }

    public function actionCabinet () {
        Common::checkLoginGuest();

        $title = 'Особистий кабінет';
        $validate_errors = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['pay']) && isset($_POST['submit'])) {
//            var_dump($_POST);
//            if (!is_int($_POST['pay'])) {
//                $validate_errors['not_int'] = false;
//            }
            if (!$_POST['pay'] > 0) {
                $validate_errors['less_than_zero'] = false;
            }

            if (count($validate_errors) == 0) {
                $result_pay = Users::userPay($_POST['pay']);
            }
        }

        $data = Users::cabinet();
        require_once(ROOT . '/views/users/cabinet.php');
        return true;
    }

    /*public function actionPay () {



        return true;
    }*/
}