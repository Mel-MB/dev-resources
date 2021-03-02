<?php   

namespace Project\Controllers\Front;
Use Project\Models\UsersManager;

class FrontController{
    public function __construct() {
        $this->UsersManager = new \Project\Models\UsersManager();
    }

    public function homePage(){
        require 'app/views/front/homepage.php';
    }
    public function login(){
         // Behaviour in case of submit
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form values
            extract(array_map("htmlspecialchars", $_POST));
            
            if(!empty($email) && !empty($password)){
                $user = $this->UsersManager->retrieveInfos($email);
                $result = $user->fetch();

                // Verify 
                $isPasswordCorrect= password_verify($password, $result['password']);
                
                if ($isPasswordCorrect){
                    //Set session
                    $_SESSION['id']= $result['id'];
                    $_SESSION['firstname']= $result['firstname'];
                    $_SESSION['email']= $result['email'];
                    $_SESSION['psw']= $result['password'];
                    
                    header('Location: index.php');
                }else{
                    $error ='Email ou mot de passe incorrect';
                }
            } else {
                $error ='Merci de renseigner vos identifiants';
            }

        }
        require 'app/views/front/login.php';
    }
    public function signup(){
        // Behaviour in case of submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form values
            extract(array_map("htmlspecialchars", $_POST));
            $psw = password_hash($password, PASSWORD_DEFAULT);
            $compulsoryFields = [$firstname,$name,$promotion,$email,$psw];
            $validation = true;

            if(in_array(null,$compulsoryFields)){
                $validation = false;
                $error = 'Veuillez remplir tous les champs.';
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $validation = false;
                $error = "L'adresse email n'est pas valide.";
            }
            if($this->UsersManager->exists($email)){
                $validation = false;
                $error = "Il existe déjà un compte pour cette adresse email.";
            }
            if($validation){
                // log new user on database
                $newUser =  $this->UsersManager->createUser($firstname, $name, $promotion,$email,$psw);               
                return require 'app/views/front/login.php';
            }
            return $error;
        }
        require 'app/views/front/signup.php';
    }
    public function postCreate(){
        
    }
}