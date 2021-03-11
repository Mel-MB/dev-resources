<?php   

namespace Project\Controllers;
Use Project\Models\Post;
Use Project\Controllers\ValidationController;

class PostsController extends Controller{
    public function __construct(){
        $this->Post = new Post;
    }
    // Posts
    public function list(){
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
    public function published(){
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
    public function create(){
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
    public function delete($id){
        // Delete post in database
        $deletePost = $this->Post->delete($id);
        // Show user posts again
        header('Location: index.php?action=my-posts');
    }
    public function update($id){
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
}