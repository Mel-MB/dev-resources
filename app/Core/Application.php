<?php

namespace Project\Core;


use  Project\Core\{Response,Request,Router,Database};

class Application{

    public static string $ROOT_DIR;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;

    public Database $db;

    public Controller $controller;

    public function __construct($rootPath,array $config){
        self::$ROOT_DIR = $rootPath;
        self::$app = $this; //allows to call actual instance of class app anywhere
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request,$this->response);
        $this->db = new Database($config['db']);
    }
   
    public function run(){
        $this->router->resolve();
    }
}