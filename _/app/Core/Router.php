<?php
namespace Project\Core;

use Project\Controllers\PagesController;
use  Project\Core\{Response,Request,Controller};
use Project\Core\Exceptions\NotFoundException;

class Router {
    private array $controllers;
    public Request $request;
    public Response $response;
    private array $routes = [];

    public function __construct(array $url_accessible_controllers){
        $this->controllers = $url_accessible_controllers;
    }

    // Set routes
    public function get(string $path, $callback): void{
        $this->routes['get'][$path] = $callback;
    }
    public function post(string $path, $callback): void{
        $this->routes['post'][$path] = $callback;
    }

    // Routing from url
    public function resolve(){
        $controller = Application::$app->controller;
        $path = Request::getUrl();
        $method = Request::method();
        //Check if there is a defined callback for this request
        $callback = $this->callbackForPath($method,$path);
        
        //If not defined
        if($callback === false){
            throw new NotFoundException();
        }
        //Check if a valid controller is passed by th url
        if(is_object($callback)){
            $param = $callback->param;
            $callback = $callback->action;
        }
        if(is_string($callback)){
            preg_match_all('/\/([^\/]*)/',$path,$sections);
            if(in_array($sections[1][0],array_keys($this->controllers))){
                $callbackArray[0] = $this->controllers[$sections[1][0]];
                $callbackArray[1] = $callback;
                $callback = $callbackArray;
            }
            $controller->action = $callback;
        }
        if (is_array($callback)){
            //create a callable Controller instance from the called class and register it as current cotroller for the app;
            $controller = new $callback[0];
            $controller->action = $callback[1];
            $callback[0] = $controller;
            // check if authorized
            foreach($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }
        // run callback
        return call_user_func($callback, $param??0);
    }
    private function callbackForPath(string $method, string $path){
        if(!isset($this->routes[$method][$path])){
            
            // Check if the given path fits dynamic path
            foreach($this->routes[$method] as $key => $value) {
                $position = strpos($key,'{');
                if ($position) {
                    preg_match('{(int|string)\s\\$[a-zA-z_]*}',$key,$match);

                    if((substr($key, 0, $position) === substr($path, 0, $position))){
                        $param = substr($path, $position);
                        $paramType = preg_match('(\d+)',$param) ? 'int' : 'string';

                        if($paramType === $match[1]){
                            return (object)[
                                'action' => $value,
                                'param' => $param
                            ];
                        }    
                    }
                }
            }
            //Given path does not exist
            return false; 
        }
        // Given path is static
        return $this->routes[$method][$path];
        
    }

}