<?php

namespace Project\Entities;

use Project\Core\{Application,Entity};

class Post extends Entity{
    const MANAGER = Project\Managers\Post::class;

    public int $id = 0;
    public string $content ='';
    public array $tags = [];

    protected function manager(){
        return self::MANAGER;
    }

    protected static function requiredAttributes(): array{
        return ['content', 'tags'];
    }
}