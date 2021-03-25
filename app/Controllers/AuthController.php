<?php

namespace Project\Controllers;

use Project\Core\{Application,Controller, Request};
use Project\Entities\{User as User};


class AuthController extends Controller{
    
    public function login(Request $request){
        $user = new User();
        // Page data
        $data = [
            'title' => 'Se connecter',
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'entity' => $user,
        ];
        
        if ($request->isPost()){
            $user->populate($request->getData());

            // if ($user->validate && $user->register()){
            //     Application::$app->session->setFlash('success', 'Thanks for registering');
            //     Application::$app->response->redirect('/');
            // }

            /* if($validator->is_valid()){
                extract($_POST);
                // Try to retrieve user from data
                $user = User::selectBy('email',$email);

                if($user && password_verify($pass, $user['password'])){
                    //Set session
                    $_SESSION['id']= $user['id'];
                    $_SESSION['pseudo']= $user['pseudo'];
                    $_SESSION['email']= $user['email'];

                    header('Location: index.php');
                    exit();
                }else{
                    $data['error'] = 'Identifiant ou mot de passe incorrect';
                }  
            }else {
                $data['error'] = 'Veuillez saisir un identifiant et un mot de passe valide';
            }*/
        }
        $this->render('front/login',$data);
    }
    public function register(Request $request){
        $user = new User();
        if($request->isPost()){
            $user->populate($request->getData());

            return $user->register();
            // if ($user->validate && $user->register()){
            //     Application::$app->session->setFlash('success', 'Thanks for registering');
            //     Application::$app->response->redirect('/');
            // }
        }
        // Page data
        $data = [
            'title' => "S'inscrire",
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'entity' => $user,
        ];
        $this->render('front/register',$data);
    }/*
    public function show(){
        //Get user account infos
        $user = User::selectEditable($_SESSION['id']);

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        $this->view('front/userAccount',$data);
    }
    public function edit(){
        $user = User::selectEditable($_SESSION['id']);

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

         // Behaviour in case of submit
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form values
            $validator= new ValidationController($_POST);
            if($validator->is_valid() && $validator->unique_checks()) {
                extract($_POST);
                $user_data=[
                    'id' => $_SESSION['id'],
                    'username' => $username,
                    'email' => $email,
                    'promotion' => $promotion,
                    'job' => $job,
                ];
                $socials_data=[
                    'own_website' => $own_website,
                    'github' => $github,
                    'linkedin' => $linkedin,
                    'discord' => $discord,
                    'codepen' => $codepen
                ];
                // Update user in database
                $update = $this->User->update($user_data,$socials_data);

                header('Location: index.php?action=account-edit');
            } else {
                $data['error'] = $validator->get_errors();
                
            }
        }

        $this->view('front/userEditAccount',$data);
    }
    public function delete(){
        // Delete user in database
        $deleteUser = User::delete($_SESSION['id']);
        session_unset();
        session_destroy();

        header('Location: index.php?action=login');
        exit();
        
    } */

}