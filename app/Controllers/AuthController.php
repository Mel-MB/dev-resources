<?php

namespace Project\Controllers;

use Project\Core\{Application, Controller, Request};
use Project\Entities\User;
use Project\Middlewares\AuthMiddleware;

class AuthController extends Controller{
    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware);
    }
    public function logout(){
        Application::$app->session->remove();
        Application::$app->session->setFlash('success', "Vous êtes déconnecté");
        header('Location: /');
    }
    public function profile(){
        //Get user account infos
        $user = User::show(Application::$app->session->get('id'));

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        return self::render('back/userAccount',$data);
    }
    public function edit(){
        //Get user account infos
        $user = User::show(Application::$app->session->get('id'));
        
        $user->rules = [
            'username' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>3], [User::RULE_MAX, 'max'=>18]],
            'email' => [User::RULE_REQUIRED, User::RULE_EMAIL],
        ];
        
        if(Request::isPost()){
            $user->populate(Request::getData());

            if ($user->validate()){
                if($user->update()){
                    Application::$app->session->setFlash('success', 'Les modifications ont été enregistrées');
                    header('Location: /mon-compte');
                    exit;
                }
            }
        }
        // Page data
        $data = [
            'title' => 'Modifier mon compte',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        return self::render('back/userEditAccount',$data);
    }
    public function delete(){
        $user = new User;
        if(!$user->delete()){
            // User Feedback
            Application::$app->session->setFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard.");
            header('Location: /modifier-mon-compte');  
            exit();
        }
        // Unset connection on session
        Application::$app->session->remove();
        // User Feedback
        Application::$app->session->setFlash('success', 'Vous êtes déconnecté');
        header('Location: /');
    }
}