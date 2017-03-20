<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 20.03.2017
 * Time: 6:10
 */
class Common
{
    public static $dataUser = [
        'login' => '',
        'balance' => '',
        'refer_id' => '',
        'referral_link' => '',
        'created' => ''
    ];

    public static function checkLoginUser () {
        if (isset($_SESSION['user'])) {
            header("Location: /user/cabinet");
        }
    }

    public static function checkLoginGuest () {
        if (!isset($_SESSION['user'])) {
            header("Location: /user/login");
        }
    }
}