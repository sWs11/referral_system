<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 15:47
 */


class Users
{

    public static function checkReferralLink ($referral_link) {
        $db = Db::getConnection();
        $query = "SELECT * FROM users WHERE referral_link = :referral_link";
        $result = $db->prepare($query);
        $result->execute(['referral_link' => $referral_link]);
        $refer_user = $result->fetchAll(PDO::FETCH_ASSOC);

        return ($refer_user);
    }


    /**
     * @param $login
     * @param $password
     * @param $referral_link
     * @param null $refer_id
     * @return int
     */
    public static function addUser ($login, $password, $referral_link, $refer_id = null) {
        $db = Db::getConnection();

        if ($refer_id != null) {
//            echo "<br> $refer_id";die;
            $values = ['login'=>$login, 'password'=>$password, 'referral_link'=>$referral_link, 'refer_id'=>$refer_id];
            $query = "INSERT INTO users (`login`, `password`, `referral_link`, `refer_id`) VALUES (:login, :password, :referral_link, :refer_id)";
        } else {
//            echo 'NN';
            $values = ['login'=>$login, 'password'=>$password, 'referral_link'=>$referral_link];
            $query = "INSERT INTO users (`login`, `password`, `referral_link`) VALUES (:login, :password, :referral_link)";
        }
        $result = $db->prepare($query);
//        $result = $db->exec($query);

        $result->execute($values);

        if (!$result) {
            echo "<br>PDO::errorInfo():<br>";
            print_r($db->errorInfo());
        }

//        $result = $db->query("SELECT * FROM users;");
//        $result->setFetchMode(PDO::FETCH_ASSOC);
//        $rows = $result->fetchAll();
//        var_dump($rows);die;
        return $result;
    }

    public static function checkLoginExists ($login, $password = null) {
        $db = Db::getConnection();

        //Перевірка під час авторизації
        if ($password != null) {
            $values = ['login' => $login, 'password' => $password];
            $query = "SELECT * FROM users WHERE login = :login AND password = :password";
        // Перевірка під час реєстрації на те чи не існує вже користувача з таким логіном
        } else {
            $values = ['login' => $login];
            $query = "SELECT * FROM users WHERE login = :login";
        }

        $result = $db->prepare($query);
        $result->execute($values);

        $user_data = $result->fetchAll(PDO::FETCH_ASSOC);

        if (count($user_data) > 0){
            return $user_data;
        }
        return false;
//        var_dump($test1);die();
    }

    public static function cabinet () {

//        Вибираємо дані про поточного користувача

        $db = Db::getConnection();
        $user_id = $_SESSION['user']['id'];
        $query = "SELECT * FROM users WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(['id'=>$user_id]);
        $user_data = $result->fetchAll(PDO::FETCH_ASSOC);

        $data['user_data'] = $user_data[0];

//--------------------------------------------------------

        $user_referrals_query = "SELECT * FROM users WHERE refer_id = :user_id";
        $user_referrals_result = $db->prepare($user_referrals_query);
        $user_referrals_result->execute(['user_id'=>$user_data[0]['id']]);
        $user_referrals_data = $user_referrals_result->fetchAll(PDO::FETCH_ASSOC);

        $data['referrals_data'] = $user_referrals_data;

//        var_dump($user_referrals_data);die;

//---------------------------------------------------------

//        Вибираємо дані(точніше тільки логін) реффера поточного користувача
        if (isset($user_data[0]['refer_id'])) {
            $user_refer_query = "SELECT login FROM users WHERE id = :id";
            $user_refer_result = $db->prepare($user_refer_query);
            $user_refer_result->execute(['id'=>$user_data[0]['refer_id']]);

            $user_refer_data = $user_refer_result->fetchAll(PDO::FETCH_ASSOC);

            $data['refer_login'] = $user_refer_data[0]['login'];
        }
//        var_dump($data);die();
        return $data;
    }

    public static function userPay ($pay) {

        global $user_id;
        global $refer_id;
        global $result_pay;
        $user_id = $_SESSION['user']['id'];
        $refer_id = $_SESSION['user']['refer_id'];
        $referral_rate = require (ROOT . '/config/referral_rate.php');

        function updateBalance ($pay, $user_id, $refer_id) {
            global $user_id;
            global $refer_id;
            global $result_pay;

            $db = Db::getConnection();
            $values = ['id' => $user_id, 'pay' => $pay];

            $user_balance_query = "UPDATE users set balance = balance + :pay WHERE id = :id";
            $user_balance_result = $db->prepare($user_balance_query);
            $user_balance_result->execute($values);
            if ($user_balance_result->rowCount() > 0) {
//                echo $user_balance_result->rowCount() . " records UPDATED successfully";
//                echo 'Поповнення балансу пройшло успішно!<br>';
                $result_pay  = true;
            } else {
                $result_pay  = false;
            }

            if ($refer_id) {
                $values = ['id' => $refer_id];
                $refer_user_query = "SELECT id, refer_id FROM users WHERE id = :id";
                $refer_user_result = $db->prepare($refer_user_query);
                $refer_user_result->execute($values);
                $refer_user_data = $refer_user_result->fetchAll(PDO::FETCH_ASSOC);

                $user_id = $refer_user_data[0]['id'];
                $refer_id = $refer_user_data[0]['refer_id'];
            } else {
                $user_id = null;
            }
        }

        updateBalance ($pay, $user_id, $refer_id);

        for ($i = 0; $i < count($referral_rate); $i++) {
            if ($user_id) {
                $pay_for_refer = $pay*$referral_rate[$i];
                updateBalance($pay_for_refer, $user_id, $refer_id);
            } else {
                break;
            }
        }
        return $result_pay;
    }


}