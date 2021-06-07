<?php

namespace Project\Entities;

use Exception;
use Project\Core\{Application, Entity};
use Project\Models\Post as PostModel;

class Post extends Entity{
    // Db Columns
    public int $id                      = 0;
    public string $title                = '';
    public string $content              = '';
    public string $link                 = '';
    public string $linkTitle            = '';
    public string $linkDomain           = '';
    public string $linkIcon             = '';
    public string $publication          = '';
    public string $username             = '';
    public $tags                        = '';
    public int $user_id                 = 0;

    private const API_ENDPOINT          = 'https://api.peekalink.io/';
    private const URL_REGEX             = '/https?:\/\/[www\.]?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b[-a-zA-Z0-9()@:%_\+.~#?&\/=]*/';

    // Manager related properties
    protected static $model             = PostModel::class;

    public function __construct(){
        if(!Application::$app->isGuest()){
            $this->user_id = Application::$app->session->get('id');
        } 
    }



    public function create(){
        $this->tags = array_map(fn($x) => $x = $x["value"],json_decode($this->tags, true));
        $attributes = self::$model::requiredAttributes();

        if(self::containsLink($this->content)){
            if($this->linkPreview(self::containsLink($this->content)[0])){
                $attributes += self::$model::linkAttributes();
            }
        }
        return self::$model::insert($this->entityToArray($attributes));
    }
    public function update($id){
        $tags = json_decode($this->tags, true);
        $this->tags = array_map(fn($x) => $x = $x["value"],$tags);

        if(!self::containsLink($this->content)){
            $this->link = null;
            $this->linkTitle = null;
            $this->linkDomain = null;
            $this->linkIcon = null;
            
        }else{
            $this->linkPreview(self::containsLink($this->content)[0]);
        }
        return self::$model::updateWhere($this->entityToArray(self::$model::editableAttributes()),['id' => $id]);
    }

    //Show
    public static function show($value,$attribute = NULL){
        if(!$attribute){
            $attribute = self::$model::$primary_key;
        }
        $post = (object) self::$model::selectOne(["$attribute" => $value]);
        return self::newInstanceFromObject($post);
    }
    public static function all(){
        $posts = self::$model::selectAll();
        return array_map(fn($post) => $post = self::newInstanceFromObject($post),$posts);
    }
    public static function search($value){
        $posts = self::$model::find($value);
        return array_map(fn($post) => $post = self::newInstanceFromObject($post),$posts);
    }
    public function fromUser(){
        $posts = self::$model::selectByUser($this->user_id);
        return $posts ? array_map(fn($post) => $post = self::newInstanceFromObject($post),$posts) : [];
    }
    public static function fromCategory($tag_name){
        $postsId = (array_map(fn($row) => $row = $row->post_id ,self::$model::getPostIdByTag($tag_name)));
        $posts = [];
        foreach($postsId as $id){
            $posts[] = self::show($id);
        }
        return $posts;
    }
    

    // API Link preview
    private function linkPreview($url): bool{
        $data = self::fetch($url);
                
        if($data->contentType === 'html'){
            $this->linkDomain = $data->domain ?? '';
            $this->link = $data->url ?? '';
            $this->linkTitle = $data->title ?? '';
            $this->linkIcon = $data->image->url ?? '';
            
            return true;
        }                       
        
        return false;
    }
    private static function fetch(string $url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::API_ENDPOINT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["link"=> $url]));
        curl_setopt($ch, CURLOPT_HTTPHEADER,[
            "X-Api-Key: a25e971f-a862-4bf4-b354-48b77fdf8cac",
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) throw new Exception('Error:'.curl_error($ch)) ;
        curl_close($ch);
        
        return json_decode($response);
    }
    private static function containsLink($content){
        preg_match(self::URL_REGEX,$content,$matches);
        if(!$matches){
            return false;
        }
        return $matches;
    }
    public function visualiseContent(){
        if($this->link===null){
            return $this->content;
        }
        return str_replace(
            $this->link,
            sprintf(
                '</p><a class="post-link" href="%s" title="Lire l\'article sur %">
                    <img src="%s" alt="%s">
                    <div class="link-description">
                        <p class="domain">%s</p>
                        <h4 class="h6">%s</h4>
                    </div>
                </a><p>',
                $this->link,
                $this->linkTitle,
                $this->linkIcon,
                $this->linkTitle,
                $this->linkDomain,
                $this->linkTitle
            ),
            $this->content
        );
    } 
    // Form handdling
    protected function labels(): array{
        return [
            'title' => 'Titre',
            'content' => 'Contenu',
            'tags' => 'Catégorie(s)'
        ];
    }
}