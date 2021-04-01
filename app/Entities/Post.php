<?php

namespace Project\Entities;

use Project\Core\{Application, Entity};
use Project\Models\Post as PostModel;

class Post extends Entity{
    // Db Columns
    public int $id                      = 0;
    public string $content              = '';
    public array $tags                  = [];
    public int $user_id                 = 0;

    protected const MODEL_NAME   = PostModel::class;

    public function __construct(){
        if(!Application::$app->isGuest()){
            $this->user_id = Application::$app->session->get('id');
        } 
    }

    

    // Form handdling
    protected function labels(): array{
        return [
            'content' => 'Message',
            'tags' => 'Catégorie(s)'
        ];
    }
}