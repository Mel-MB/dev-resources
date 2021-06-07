<?php   

namespace Project\Controllers;

use Project\Core\{Application,Controller,Request};
use Project\Entities\Post;
use Project\Middlewares\AuthMiddleware;

class PostsController extends Controller{
    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware(['search']));
    }
    public function create(){
        $post = new Post;
        
        $post->rules = [
            'content' => [Post::RULE_REQUIRED, [Post::RULE_MIN, 'min'=>50], [Post::RULE_MAX, 'max'=>1000]],
            'tags' => [Post::RULE_REQUIRED]
        ];
        
        if(Request::isPost()){
            $post->populate(Request::getData());

            if ($post->validate()){
                if($post->create()){
                    Application::$app->session->setFlash('success', 'Votre contribution a bien été ajoutée');
                    header('Location: /');
                    return;
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
        
        return self::render('back/_postForm',$data);
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
        return self::render('back/userPosts',$data);
        
    }
    public function update(int $id){
        // Retrieve previous post content
        $post= Post::show($id);
        $post->rules = [
            'content' => [Post::RULE_REQUIRED, [Post::RULE_MIN, 'min'=>50], [Post::RULE_MAX, 'max'=>1000]],
            'tags' => [Post::RULE_REQUIRED]
        ];
        
        if(Request::isPost()){
            $post->populate(Request::getData());

            if ($post->validate()){
                if($post->update($id)){
                    Application::$app->session->setFlash('success', 'Les modifications ont été enregistrées');
                    header('Location: /mes-posts');
                    return;
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
        return self::render('back/_postForm',$data);
    }
    public function delete(int $id){
        $post = new Post();
        if(!$post->delete($id)){
            Application::$app->session->setFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard.");
            return json_encode(false);
        }
        return json_encode(true);
    }
    public function search(){
        $requested = json_decode(file_get_contents('php://input'),true)['query'];
        $posts = Post::search($requested);
        $nbPosts = sizeof($posts) ?? 'Aucun';

        // Page data
        $data = [
            'title' => "$nbPosts resources partagées sur \"$requested\".",
            'posts' => $posts
        ];
        return self::render('front/searchResult',$data);
    }
}