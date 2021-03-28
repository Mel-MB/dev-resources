<?php

namespace Project\Controllers;

use Project\Core\{Application, Controller, Request};
use Project\Entities\User;


class AuthController extends Controller{
    public function login(Request $request){

        $user = new User();
        $user->rules = [
            'username' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>3], [User::RULE_MAX, 'max'=>18]],
            'password' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>8]]
        ];

        if ($request->isPost()){
            $user->populate($request->getData());
 
            if($user->validate()){
                if($user->connect()){
                    Application::$app->session->setFlash('success', "Vous êtes connecté");
                    header('Location: /');
                    exit;
                } else {
                    Application::$app->session->setFlash('error', "Pseudo ou mot de passe incorrect");
                }
            }    
        }
        
        // Page data
        $data = [
            'title' => 'Se connecter',
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'entity' => $user,
        ];
        
        return $this->render('front/login',$data);
    }
    public function logout(){
        Application::$app->logout();
        header('Location: /');
        exit;
    }
    public function register(Request $request){
        $user = new User();
        $user->rules = [
            'username' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>3], [User::RULE_MAX, 'max'=>18],User::RULE_UNIQUE],
            'email' => [User::RULE_REQUIRED, User::RULE_EMAIL,User::RULE_UNIQUE],
            'promotion' => [User::RULE_REQUIRED, User::RULE_YEAR],
            'password' => [User::RULE_REQUIRED, [User::RULE_MIN, 'min'=>8]],
            'passwordConfirm' => [User::RULE_REQUIRED, [User::RULE_MATCH, 'match'=> 'password']]
        ];
        
        if($request->isPost()){
            $user->populate($request->getData());

            if ($user->validate()){
                try{
                    $user->create();
                    Application::$app->session->setFlash('success', 'Vous êtes inscrit');
                    header('Location: /se-connecter');
                    exit;
                }catch(\Exception $e){
                    Application::$app->session->setFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard");
                }
            }
        }

        // Page data
        $data = [
            'title' => "S'inscrire",
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'entity' => $user,
        ];

        return $this->render('front/register',$data);
    }
    public function profile(){
        //Get user account infos
        $user = Application::$app->user;

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        $this->render('front/userAccount',$data);
    }
    public function edit(Request $request){
        $user = Application::$app->user;
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
                    header('Location: /votre-profil');
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

        $this->render('front/userEditAccount',$data);
    }
    public function delete(){
        // Delete user in database
        $deleteUser = User::delete($_SESSION['id']);
        session_unset();
        session_destroy();

        header('Location: index.php?action=login');
        exit();
        
    }
}