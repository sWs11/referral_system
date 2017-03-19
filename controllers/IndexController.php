<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.03.2017
 * Time: 1:44
 */
include_once ROOT . '/models/Index.php';

class IndexController
{
    public function actionIndex () {

        $test = Index::newUser();

//        print_r($test);

//        echo "<br><br> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus autem cumque debitis eaque, eius eos, et fuga fugit, laboriosam molestiae necessitatibus nemo nobis numquam porro quae quod repellendus sequi tenetur.";

        require_once (ROOT. '/views/index/index.php');

        return true;
    }

    public function actionAdd_user () {



    }
}