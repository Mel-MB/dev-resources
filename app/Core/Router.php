<?php
namespace Project\Core;

use Project\Controllers\PagesController;
use  Project\Core\{Response,Request,Controller};
use Project\Core\Exceptions\NotFoundException;

class Router {
    private array $controllers = ['post','auth',''];

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
    }

    public function get($path, $callback){
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback){
        $this->routes['post'][$path] = $callback;
    }


    public function resolve(){
        $app_controller = Application::$app->controller;
        $path = $this->request::getUrl();
        $method = $this->request->method();
        //Check if there is a defined callback for this request
        $callback = fitsCallback($method,$path);
    
        if($callback === false){
            throw new NotFoundException();
        }
        //Render view if the callback is defined as a string
        if (is_string($callback)){
            return $app_controller->$callback;
        }
        //Call the appropriate function if the callback is an array
        if (is_array($callback)){
            //create a callable Controller instance from the called class and register it as current cotroller for the app;
            $controller = Application::$app->setController(new $callback[0]());
            $controller->action = $callback[1];
            $callback[0] = $controller;

            // check if authorized
            foreach($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
            // run callback
            return call_user_func($callback, $this->request);
        }
    }

    private function fitsCallback(string $method, array $path){
        if($path[1]){
            if(preg_match_all('/\/\{(\?*[a-z]*)\s\$[a-zA-Z0-9_]*\}/',$callback,$params)){
                
            }
        }
        '/\/\$\{([\?]*[a-z0-9_]*)\}/i'

        return $this->routes[$method][$path] ?? false;
    }
    
}