<?php

namespace Project\Middlewares;

use Project\Core\Application;
use Project\Core\Exceptions\ForbiddenException;
use Project\Core\Middleware;

class AuthMiddleware extends Middleware{

    public function execute(){
        if(Application::isGuest()){
            if(empty($this->actions) || !in_array(Application::$app->controller->action,$this->actions)){
                throw new ForbiddenException;
            }
        }
    }

    public static function canUpdateDelete($subject_userId){
        return $subject_userId == Application::$app->session->get('id');
            
    }
}