<?php

namespace Project\Controllers;

use Project\Core\{Application, Controller, Request};
use Project\Entities\{Post, User};
use Project\Models\Tag;

class PagesController extends Controller{
    public function home(){
        // Research bar
        $mostUsedTags = Tag::selectTop5();
        //Retrieve all posts
        $posts= Post::all();
        // Page data
         $data = [
            'tags' => $mostUsedTags,
            'posts' => $posts
         ];
         return self::render('front/home',$data);
    }
    public function category(string $tag_name){
        $posts= Post::fromCategory($tag_name);;
        $nbPosts = sizeof($posts) ?? 'Aucun';
        $units = ($nbPosts === 1)?'resource partagée':'resources partagées';
        // Page data
        $data = [
            'title' => "$nbPosts $units sur $tag_name.",
            'posts' => $posts
        ];
        return self::render('front/searchResult',$data);
    }
    public function login(){
        $user = new User;
        $user->rules = [
            'username' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>3], [User::RULE_MAX, 'max'=>18]],
            'password' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>8]]
        ];

        if (Request::isPost()){
            $user->populate(Request::getData());
 
            if($user->validate()){
                if($user->connect()){
                    Application::$app->session->setFlash('success', "Vous êtes connecté");
                    header('Location: /');
                    exit;
                }
                Application::$app->session->setFlash('error', "Pseudo ou mot de passe incorrect");
            }
        }    
        
        // Page data
        $data = [
            'title' => 'Se connecter',
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'user' => $user,
        ];
        
        return self::render('front/login',$data);
    }
    public function register(){
        $user = new User;
        $user->rules = [
            'username' => [User::RULE_REQUIRED, User::RULE_ALPHANUM, [User::RULE_MIN, 'min'=>3], [User::RULE_MAX, 'max'=>18], User::RULE_UNIQUE],
            'email' => [User::RULE_REQUIRED, User::RULE_EMAIL, User::RULE_UNIQUE],
            'password' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>8]],
            'password_confirm' => [User::RULE_REQUIRED, [User::RULE_MATCH, 'match'=> 'password']]
        ];
        
        if(Request::isPost()){
            $user->populate(Request::getData());

            if ($user->validate()){
                if($user->create()){
                    Application::$app->session->setFlash('success', 'Vous êtes inscrit');
                    header('Location: /se-connecter');
                    exit;
                }
                Application::$app->session->setFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard");
            }           
        }

        // Page data
        $data = [
            'title' => "S'inscrire",
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'user' => $user,
        ];

        return self::render('front/register',$data);
    }
}