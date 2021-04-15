<?php

namespace Project\Entities;

use Project\Core\{Application, Entity};
use Project\Models\Post as PostModel;

class Post extends Entity{
    // Db Columns
    public int $id                      = 0;
    public string $content              = '';
    public string $username             = '';
    public $tags                        = '';
    public int $user_id                 = 0;

    // Manager related properties
    protected static $model             = PostModel::class;

    public function __construct(){
        if(!Application::$app->isGuest()){
            $this->user_id = Application::$app->session->get('id');
        } 
    }

    public function create(){
        $tags = json_decode($this->tags, true);
        $this->tags = array_map(fn($x) => $x = $x["value"],$tags);
        
        return self::$model::insert($this->entityToArray(self::$model::requiredAttributes()));
    }
    public function update($id){
        $tags = json_decode($this->tags, true);
        $this->tags = array_map(fn($x) => $x = $x["value"],$tags);
        
        return self::$model::updateWhere($this->entityToArray(self::$model::editableAttributes()),['id' => $id]);
        
    }

    //Show
    public static function show($value,$attribute = NULL){
        if(!$attribute){
            $attribute = self::$model::$primary_key;
        }
        $post = self::$model::selectOne(["$attribute" => $value]);
        return self::newInstanceFromObject($post);
    }
    public static function all(){
        $posts = self::$model::selectAll();
        return array_map(fn($post) => $post = self::newInstanceFromObject($post),$posts);
    }
    public function fromUser(){
        $posts = self::$model::selectByUser($this->user_id);
        return $posts ? array_map(fn($post) => $post = self::newInstanceFromObject($post),$posts) : [];
    }
    

    // Form handdling
    protected function labels(): array{
        return [
            'content' => 'Contenu',
            'tags' => 'Catégorie(s)'
        ];
    }
}