<?php
namespace Project\Core;

use Project\Controllers\PagesController;
use  Project\Core\{Response,Request,Controller};
use Project\Core\Exceptions\NotFoundException;

class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback){
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback){
        $this->routes['post'][$path] = $callback;
    }


    public function resolve(){
        $path = $this->request->getUrl();
        $method = $this->request->method();
        //Check if there is a defined callback for this request
        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false){
            throw new NotFoundException();
        }
        //Render view if the callback is defined as a string
        if (is_string($callback)){
            Application::$app->setController(new PagesController());
            return Application::$app->controller->render($callback);
        }
        //Call the appropriate function if the callback is an array
        if (is_array($callback)){
            //create a callable Controller instance from the called class and register it as current cotroller for the app;
            Application::$app->setController(new $callback[0]());
            $controller = Application::$app->controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }

            // run callback
            return call_user_func($callback, $this->request);
        }
    }
    
}