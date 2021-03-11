<?php   

namespace Project\Controllers;
Use Project\Models\User;
Use Project\Controllers\ValidationController;

class UsersController extends Controller{
    public function __construct(){
        $this->User = new User;
    }

    //User
    public function login(){
        // Page data
        $data = [
            'title' => 'Se connecter',
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
        ];

         // Behaviour in case of submit
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form values
            $validator= new ValidationController($_POST);

            if($validator->is_valid()){
                extract($_POST);
                // Try to retrieve user from data
                $user = User::selectByEmail($email);

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
            }
        }
        $this->view('front/login',$data);
    }
    public function signup(){
        // Page data
        $data = [
            'title' => "S'inscrire",
            'description' => "Créer un compte donnant accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",

        ];
        // Behaviour in case of submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form values
            $validator= new ValidationController($_POST);
            
            if($validator->is_valid() && $validator->is_unique()){
                extract($_POST);
                $psw = password_hash($password, PASSWORD_DEFAULT);
                
                // log new user on database
                $newUser =  User::create($pseudo, $promotion,$email,$psw);               
                header('Location: index.php?action=login');
                exit();
            }
            $data['error'] = $validator->get_errors();
        }
        $this->view('front/signup',$data);
    }
    public function show(){
        //Get user account infos
        $user = User::selectByEmail($_SESSION['email']);

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        $this->view('front/userAccount',$data);
    }
    public function edit(){
        $user = $this->User->selectByEmail($_SESSION['email']);

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        $this->view('front/userEditAccount',$data);
    }
    public function delete(){
        // Delete user in database
        $deleteUser = User::delete($_SESSION['id']);
        session_unset();
        session_destroy();

        header('Location: index.php?action=login');
        exit();
        
    }
    public function update(){
        // Validate form values
        $validator= new ValidationController($_POST);
        if($validator->is_valid() && $validator->is_unique()) {
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
            var_dump($update);
            die;
        } else {
            $data['error'] = $validator->get_errors();
            var_dump($data['error']);
            die;
        }
        

    }
    
}