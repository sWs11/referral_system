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
        }
    }

    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri)) {

/*                $reg = 'user/add/(\w+)';
                $strIn = $uri;
                $strOut = "users/add/$1";

                echo preg_replace("~$reg~", $strOut, $strIn);*/

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segment = explode('/', $internalRoute);

                /*echo "<br> defaul";
                var_dump($segment);*/

                $controllerName = array_shift($segment).'Controller';
                $controllerName = ucfirst($controllerName);

                /*echo "<br> after take controller name";
                var_dump($segment);*/

                $actionName = 'action'.ucfirst(array_shift($segment));

                /*echo "<br> after take action name";
                var_dump($segment);*/

                $parameter = $segment;

                $controllerFile = ROOT. '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }

                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName($parameter);
                if ($result != null) {
                    break;
                }
            }
        }
    }
}