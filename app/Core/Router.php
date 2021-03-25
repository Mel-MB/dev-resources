<?php

namespace Project\Core;

use  Project\Core\{Response,Request};

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
            Application::$app->response->setStatusCode(404);
            return $this->renderView("_404");
        }
        //Render view if the callback is defined as a string
        if (is_string($callback)){
            return $this->renderView($callback);
        }
        //Call the appropriate function if the callback is an array
        if (is_array($callback)){
            //create a callable Controller instance from the called class;
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        return call_user_func($callback, $this->request);
    }

    // Load view
    public function renderView($view, array $data =[]){
        

        $layoutContent = $this->renderLayout($data);
        $viewContent = $this->renderContent($view,$data);
         
        return str_replace('{{-content-}}',$viewContent,$layoutContent);
       }

    //Load content only
    public function renderContent($view, array $data = []){
        //Allow view to use the passed in data as varibles
        foreach ($data as $key => $value){
            //Create a variable named by its key variable and affect it to its value
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/app/views/$view.php";
        return ob_get_clean();
    }

    private function renderLayout($data = null){
        $layout = Application::$app->controller->layout;
        $data ?? [
            'title' => 'Partage de ressources Kercode',
            'description' => 'Le blog de partage et classification de ressources de étudiants de Kercode'
        ];

        //Allow view to use the passed in data as varibles
        foreach ($data as $key => $value){
            //Create a variable named by its key variable and affect it to its value
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/app/views/layouts/$layout.php";
        return ob_get_clean();
    }
    
}