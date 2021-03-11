<?php
session_start();
use Project\Controllers\PostsController;
use Project\Controllers\UsersController;

require_once __DIR__ . '/vendor/autoload.php';

try{
    $post = new PostsController;
    $user = new UsersController;
    
    //Default behaviour if no action set
    if(!isset($_GET['action'])) return $post->list();
    
    if(isset($_SESSION['id'])){
        // Actions for user only
        switch($_GET['action']){
            case 'signout':
                session_unset();
                session_destroy();
                header('Location: index.php');
            break;
            case 'post-create':
                $post->create();
            break;
            case 'my-posts':
                $post->published();
            break;
            case 'my-account':
                $user->show();
            break;
            case 'account-edit':
                $user->edit();
            break;
            case 'account-update':
                $user->update();
            break;
            case 'account-delete':
                $user->delete();
            break;
            case 'post-update':
                $id= $_GET['id'];
                $post->update($id);
            break;
            case 'post-delete':
                $id= $_GET['id'];
                $post->delete($id);
            break;
        }
    }else{
        //Actions accessible without session being set
        switch($_GET['action']){
            case 'login':
                $user->login();
            break;
            case 'signup':
                $user->signup();
            break;
            default: $post->list();
        };
    }
}catch(Exception $e){
    die('Erreur: '.$e->getMessage());
}