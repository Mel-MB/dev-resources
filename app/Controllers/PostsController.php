<?php   

namespace Project\Controllers;

use Project\Core\Application;
use Project\Core\Controller;
use Project\Core\Request;
use Project\Entities\Post;
use Project\Middlewares\AuthMiddleware;

class PostsController extends Controller{
    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware(['list','userPublished']));
    }

    public function list(){
        //Retrieve all posts
        $posts= Post::all();
        
        // Page data
        $data = [
            'title' => 'Partage de ressources Kercode',
            'description' => 'Le blog de partage et classification de ressources de étudiants de Kercode',
            'posts' => $posts
        ];
        $this->render('front/homepage',$data);
    }

    public function create(Request $request){
        $post = new Post;
        
        $post->rules = [
            'content' => [Post::RULE_REQUIRED, [Post::RULE_MIN, 'min'=>50], [Post::RULE_MAX, 'max'=>1000]],
            'tags' => [Post::RULE_REQUIRED]
        ];
        
        if($request->isPost()){
            $post->populate($request->getData());

            if ($post->validate()){
                if($post->create()){
                    Application::$app->session->setFlash('success', 'Les modifications ont été enregistrées');
                    header('Location: /');
                    exit;
                }
            }
        }
        // Page data
        $data = [
            'title' => "Nouveau post",
            'description' => "Partager un contenu aux étudiants de Kercode",
            'submitMessage' => 'Publier',
            'post' => $post
        ];
        
        return $this->render('front/_postForm',$data);
    }
    public function userPublished(){
        $user_posts = Post::fromUser();
        
        // Page data
        $data = [
            'title' => "Mes contenus postés",
            'description' => "Gérer mes contenus partagés aux autres étudiants",
            'user_posts' =>  $user_posts
        ];
        return $this->render('front/userPosts',$data);
        
    }

    public function delete($id){
        $post = new Post();
        // Delete post in database
        $deletePost = $post->delete($id);
        // Show user posts again
        header('Location: index.php?action=my-posts');
    }
    public function update(Request $request, int $id){
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