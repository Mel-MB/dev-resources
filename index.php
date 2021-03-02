<?php
session_start();
use Project\Controllers\Front\FrontController;

require_once __DIR__ . '/vendor/autoload.php';

try{
    $frontController = new \Project\Controllers\Front\FrontController();
    
    //Default behaviour if no action set
    if(!isset($_GET['action'])) return $frontController->homePage();
    
    if(isset($_SESSION['id'])){
        // Actions for user only
        switch($_GET['action']){
            case 'signout':
                session_unset();
                session_destroy();
                header('Location: index.php');
            break;
            case 'postCreate':
                $frontController->postCreate();
            break;

        }
    }else{
        //Actions accessible without session being set
        switch($_GET['action']){
            case 'login':
                $frontController->login();
            break;
            case 'signup':
                $frontController->signup();
            break;
        };
    }
}catch(Exception $e){
    die('Erreur: '.$e->getMessage());
}