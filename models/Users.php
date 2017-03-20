<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 15:47
 */


class Users
{
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
            echo 'null';
//            $query = 'INSERT INTO users (login, password, referral_link)' ;
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
            $user_referr_query = "SELECT login FROM users WHERE id = :id";
            $user_referr_result = $db->prepare($user_referr_query);
            $user_referr_result->execute(['id'=>$user_data[0]['refer_id']]);

            $user_referr_data = $user_referr_result->fetchAll(PDO::FETCH_ASSOC);

            $data['reffer_login'] = $user_referr_data[0]['login'];
        }
//        var_dump($data);die();
        return $data;
    }

}