<?php

namespace Project\Entities;

use Error;
use Project\Core\{Application, Entity};
use Project\Models\Post as PostModel;

class Post extends Entity{
    // Db Columns
    public int $id                      = 0;
    public string $content              = '';
    public array $tags                  = [];
    public int $user_id                 = 0;

    // Manager related properties
    protected static PostModel $model;

    public function __construct(){
        self::$model = new \Project\Models\Post();
        if(!Application::$app->isGuest()){
            $this->user_id = Application::$app->session->get('id');
        } 
    }


}