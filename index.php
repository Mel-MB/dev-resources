<?php
session_start();
use Project\Controllers\Pages;

require_once __DIR__ . '/vendor/autoload.php';

try{
    $pages = new \Project\Controllers\Pages();
    
    //Default behaviour if no action set
    if(!isset($_GET['action'])) return $pages->homePage();
    
    if(isset($_SESSION['id'])){
        // Actions for user only
        switch($_GET['action']){
            case 'signout':
                session_unset();
                session_destroy();
                header('Location: index.php');
            break;
            case 'post-create':
                $pages->postCreate();
            break;
            case 'my-profile':
                $pages->userProfile();
            break;
            case 'my-posts':
                $pages->userPosts();
            break;
            case 'my-account':
                $pages->userAccount();
            break;
            case 'account-edit':
                $pages->accountEdit();
            break;
            case 'post-update':
                $id= $_GET['id'];
                $pages->postUpdate($id);
            break;
            case 'post-delete':
                $id= $_GET['id'];
                $pages->postDelete($id);
            break;
        }
    }else{
        //Actions accessible without session being set
        switch($_GET['action']){
            case 'login':
                $pages->login();
            break;
            case 'signup':
                $pages->signup();
            break;
            default: $pages->homePage();
        };
    }
}catch(Exception $e){
    die('Erreur: '.$e->getMessage());
}