<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 2:35
 */
class Index
{
    public static function newUser () {
        $db = Db::getConnection();

        $result = $db->query('SELECT * from testtable');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $item = $result->fetch();

        return $item;
    }

}