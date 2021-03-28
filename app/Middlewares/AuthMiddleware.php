<?php

namespace Project\Middlewares;

use Project\Core\Application;
use Project\Core\Middleware;

class AuthMiddlware extends Middleware{

    public function execute(){
        if( Application::isGuest()){
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)){
                
            }
        }
    }
}