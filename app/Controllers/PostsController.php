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
                Application::$app->session->setFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard.");
            }
        }
        // Page data
        $data = [
            'title' => "Nouveau post",
            'description' => "Partager un contenu aux étudiants de Kercode",
            'submitMessage' => 'Publier',
            'post' => $post
        ];
        
        return self::render('front/_postForm',$data);
    }
    public function userPublished(){
        $posts = new Post;
        $user_posts = $posts->fromUser();
        
        // Page data
        $data = [
            'title' => "Mes contenus postés",
            'description' => "Gérer mes contenus partagés aux autres étudiants",
            'user_posts' =>  $user_posts
        ];
        return self::render('front/userPosts',$data);
        
    }
    public function update(Request $request, int $id){
        // Retrieve previous post content
        $post= Post::show($id);
        $post->rules = [
            'content' => [Post::RULE_REQUIRED, [Post::RULE_MIN, 'min'=>50], [Post::RULE_MAX, 'max'=>1000]],
            'tags' => [Post::RULE_REQUIRED]
        ];
        
        if($request->isPost()){
            $post->populate($request->getData());

            if ($post->validate()){
                if($post->update($id)){
                    Application::$app->session->setFlash('success', 'Les modifications ont été enregistrées');
                    header('Location: /mes-posts');
                    exit;
                }
                Application::$app->session->setFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard.");
            }
        }

        // Page data
        $data = [
            'title' => "Modifier un post",
            'description' => "Modifier un contenu partagé aux étudiants de Kercode",
            'submitMessage' => 'Mettre à jour',
            'post' => $post
        ];
        return self::render('front/_postForm',$data);
    }
    public function delete(Request $request, int $id){
        $post = new Post();
        if(!$post->delete($id)){
            Application::$app->session->setFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard.");
        }
    }
}