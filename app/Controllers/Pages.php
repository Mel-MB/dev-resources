<?php   

namespace Project\Controllers;
Use Project\Models\User;
Use Project\Models\Post;

class Pages extends Controller{
    public function __construct() {
        $this->User = new User;
        $this->Post = new Post;
    }

    public function homePage(){
        //Retrieve all posts
        $posts= $this->Post->retrievePosts();
        // Page data
        $data = [
            'title' => 'Partage de ressources Kercode',
            'description' => 'Le blog de partage et classification de ressources de étudiants de Kercode',
            'posts' => $posts
        ];
        $this->view('front/homepage',$data);
    }

    //User
    public function login(){
        // Page data
        $data = [
            'title' => 'Se connecter',
            'description' => "Accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'error' => $error ?? null
        ];
         // Behaviour in case of submit
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form values
            extract(array_map("htmlspecialchars", $_POST));
            
            if(!empty($email) && !empty($password)){
                $user = $this->User->retrieveData($email);
                // Verify 
                $isPasswordCorrect= password_verify($password, $user['password']);
                
                if ($isPasswordCorrect){
                    //Set session
                    $_SESSION['id']= $user['id'];
                    $_SESSION['firstname']= $user['firstname'];
                    $_SESSION['email']= $user['email'];
                    
                    header('Location: index.php');
                }else{
                    $error ='Email ou mot de passe incorrect';
                }
            } else {
                $error ='Merci de renseigner vos identifiants';
            }

        }
        $this->view('front/login',$data);
    }
    public function signup(){
        // Page data
        $data = [
            'title' => "S'inscrire",
            'description' => "Créer un compte donnant accès à l'espace personnel de partage et classification de ressources de étudiants de Kercode",
            'error' => $error ?? null
        ];
        // Behaviour in case of submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form values
            $post_data = extract(array_map("htmlspecialchars", $_POST));
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
            if($this->User->exists($email)){
                $validation = false;
                $error = "Il existe déjà un compte pour cette adresse email.";
            }
            if($validation){
                // log new user on database
                $newUser =  $this->User->create($firstname, $name, $promotion,$email,$psw);               
                header('Location: index.php?action=login');
            }
        }
        $this->view('front/signup',$data);
    }
    public function userProfile(){

        $this->view('front/userProfile',$data);
    }
    
    // Posts
    public function userPosts(){
        //Retrieve user posts
        $user_id = $_SESSION['id'];
        
        $user_posts = $this->Post->user_posts($user_id);
        
        // Page data
        $data = [
            'title' => "Mes contenus postés",
            'description' => "Gérer mes contenus partagés aux autres étudiants",
            'user_posts' => $user_posts
        ];
        $this->view('front/userPosts',$data);
        
    }
    
    public function postCreate(){
        // Page data
        $data = [
            'title' => "Nouveau post",
            'description' => "Partager un contenu aux étudiants de Kercode",
            'submitMessage' => 'Publier'
        ];
        
        // Behaviour in case of submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form content
            $postContent = htmlentities($_POST['pContent']);
            $user_email = $_SESSION['email'];
            
            // Link treatment
            $link = null;
            
            // Create new post in database
            $newPost = $this->Post->create($link, $postContent, $user_email);
            
            header('Location: index.php');
        }
        return $this->view('front/postForm',$data);
    }
    public function postDelete($id){
        // Delete post in database
        $deletePost = $this->Post->delete($id);
        // Show user posts again
        header('Location: index.php?action=my-posts');
    }
    public function postUpdate($id){
        // Retrieve previous post content
        $previousPost= $this->Post->retrievePost($id);
        // Page data
        $data = [
            'title' => "Modifier un post",
            'description' => "Modifier un contenu partagé aux étudiants de Kercode",
            'submitMessage' => 'Mettre à jour',
            'post' => $previousPost
        ];
        
        // Behaviour in case of submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form content
            $postContent = htmlentities($_POST['pContent']);
            
            // Link treatment
            $link = null;
            
            // Create new post in database
            $updatePost = $this->Post->update($id,$link, $postContent);
            header('Location: index.php');
        }
        return $this->view('front/postForm',$data);
    }
    // User
    public function userAccount(){
        //Get user account infos
        $user = $this->User->retrieveData($_SESSION['email']);

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        $this->view('front/userAccount',$data);
    }
    public function accountEdit(){
        $user = $this->User->retrieveData($_SESSION['email']);

        // Page data
        $data = [
            'title' => 'Mon compte utilisateur',
            'description' => "Espace personnel permet de visualiser les informations de votre compte sur le site de partage Kercode",
            'user' => $user
        ];

        $this->view('front/userEditAccount',$data);
    }
}