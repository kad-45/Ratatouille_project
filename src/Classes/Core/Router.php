<?php
namespace App\Classes\Core;

class Router {

    /**
     * Permet d'executer une requette http
     * http://hostname/uri.
     * uri sous la forme de /controller/action/paramettre.
     * @return void.
     */
    public function run(){

        $uri = $_SERVER['REQUEST_URI'];

        if(!empty($uri) && $uri != '/' && $uri[-1] ==='/'){
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: '.$uri);
            exit;
        
        }
        $params = explode('/', $_GET['param']) ;

        if($params[0] != ""){
            $controllerClasse = '\\App\\Classes\\Controllers\\'.ucfirst(array_shift($params)).'Controller';
            $action  = isset($params[0]) ?  array_shift($params): 'index';
        
            $controller = new $controllerClasse();

            if(method_exists($controller, $action)) {
                (isset($params[0])) ? $controller->$action($params[0]) : $controller->$action();

            } else {
                $controller = new \App\Classes\Controllers\ErrorController;
                $controller->index();
    
            }
        } else {

            $controller = new \App\Classes\Controllers\HomeController;
            $controller->index();
        }
    }
}