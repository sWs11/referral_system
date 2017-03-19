<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 4:41
 */
class Db
{
    public static function getConnection () {
        $params = include(ROOT.'/config/db_params.php');

        $dsn = "mysql:host=$params[host];dbname=$params[dbname]";
        $db = new PDO($dsn, $params['dbuser'], $params['dbpass'], $params['options']);

        return $db;
    }
}