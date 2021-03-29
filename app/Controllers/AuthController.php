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
        $user = new User;
        $user = $user->show(Application::$app->session->get('id'));

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        return $this->render('front/userAccount',$data);
    }
    public function edit(Request $request){
        //Get user account infos
        $user = new User;
        $user = $user->show(Application::$app->session->get('id'));
        
        $user->rules = [
            'username' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>3], [User::RULE_MAX, 'max'=>18]],
            'email' => [User::RULE_REQUIRED, User::RULE_EMAIL],
            'promotion' => [User::RULE_REQUIRED, User::RULE_YEAR],
        ];
        
        if($request->isPost()){
            $user->populate($request->getData());

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
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        return $this->render('front/userEditAccount',$data);
    }
    public function delete(){
        // Delete user in database
        $user = new User;
        $user->delete();
        // Unset session
        Application::$app->session->remove();

        Application::$app->session->setFlash('success', 'Vous êtes déconnecté');
        header('Location: /');
        exit();
        
    }

}