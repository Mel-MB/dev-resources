<?php   

namespace Project\Controllers;
Use Project\Manager\Post;
Use Project\Controllers\ValidationController;

class PostsController extends Controller{
    public function __construct(){
        $this->Post = new Post;
    }
    // Posts
    public function list(){
        //Retrieve all posts
        $posts= Post::allPosts();
        if($posts){
            foreach($posts as $post){
                $post= array_map('htmlentities',$post);
            }
        }
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
        
        $user_posts = Post::user_posts($user_id);
        if($user_posts){
            foreach($user_posts as $post){
                $post= array_map('htmlentities',$post);
            }
        }
        
        // Page data
        $data = [
            'title' => "Mes contenus postés",
            'description' => "Gérer mes contenus partagés aux autres étudiants",
            'user_posts' =>  $user_posts
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
               
            // Create new post in database
            $newPost = Post::create($_POST['pContent'], $_SESSION['id']);
            
            header('Location: index.php');
        }
        return $this->view('front/postForm',$data);
    }
    public function delete($id){
        // Delete post in database
        $deletePost = Post::delete($id);
        // Show user posts again
        header('Location: index.php?action=my-posts');
    }
    public function update($id){
        // Retrieve previous post content
        $previousPost= Post::selectBy('id',$id);
        // Page data
        $data = [
            'title' => "Modifier un post",
            'description' => "Modifier un contenu partagé aux étudiants de Kercode",
            'submitMessage' => 'Mettre à jour',
            'post' => array_map('htmlentities',$previousPost)
        ];
        
        // Behaviour in case of submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Create new post in database
            $updatePost = $this->Post->update($id, $_POST['pContent']);
            header('Location: index.php');
        }
        return $this->view('front/postForm',$data);
    }
}