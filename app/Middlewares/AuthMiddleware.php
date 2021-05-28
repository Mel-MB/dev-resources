<?php

namespace Project\Middlewares;

use Project\Core\Application;
use Project\Core\Exceptions\ForbiddenException;
use Project\Core\Middleware;
use Project\Models\User;

class AuthMiddleware extends Middleware{
    private static bool $isAdmin;

    public function execute(){
        if(Application::isGuest()){
            if(empty($this->actions) || !in_array(Application::$app->controller->action,$this->actions)){
                throw new ForbiddenException;
            }
        }
    }
    public static function canUpdateDelete($subject_userId):bool{
        if(self::userRole() || self::isAuthor($subject_userId)){
            return true;
        }
        return false;
    }
    public static function isAuthor($subject_userId):bool {
        return $subject_userId == Application::$app->session->get('id');    
    }
    public static function userRole():bool{
        if(isset(self::$isAdmin)){
            return self::$isAdmin;
        }
        return User::getRole(Application::$app->session->get('id'));
    }
}