<?php

/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 18.03.2017
 * Time: 22:27
 */
class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getURI ()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
//
            $pattern = '~(.+)\?XDEBUG.+~i';
            $replacement = '${1}';

//            echo "{$_SERVER['REQUEST_URI']}<br>";
//            echo preg_replace($pattern, $replacement, $_SERVER['REQUEST_URI']);
            $uri = preg_replace($pattern, $replacement, $_SERVER['REQUEST_URI']);

            if ($uri == '/') {
                return  'index';
            }
            return  trim($uri, '/');
//            return  $_SERVER['REQUEST_URI'];
        }
    }

    public function run()
    {
        $uri = $this->getURI();
//        $pattern = '~(\?\w+[=]+\d+$)~';XDEBUG




/*        $string = $uri;
        $pattern = '~(\?\w+$)~i';
        $replacement = 'test| ${1} |test';
        echo preg_replace($pattern, $replacement, $string);*/
//        echo $replacement;
//        echo "<br>$string";
//        die();

        foreach ($this->routes as $uriPattern => $path) {

//            echo "<br>$uriPattern";

            if (preg_match("~$uriPattern~", $uri)) {

//                echo "<br>";
/*                echo "<br>uri = $uri";
                echo "<br>key = $uriPattern";
                echo "<br>path = $path";*/

                $segment = explode('/', $path);

                $controllerName = array_shift($segment).'Controller';
                $controllerName = ucfirst($controllerName);

//                var_dump($segment);die;

//                echo "<br>controllerName = $controllerName";

                $actionName = 'action'.ucfirst(array_shift($segment));

//                echo "<br>actionName = $actionName";

                $controllerFile = ROOT. '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }

                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }
            }
        }
    }
}