<?php 

namespace Project\Core;

use Stringable;

class Controller{

    public string $layout ='main';

    protected function setLayout($layout){
        $this->layout = $layout;
    }
    protected function render($view, $data = []){
         echo Application::$app->router->renderView($view, $data);
         exit;
    }
}