<?php

namespace Project\Models;

use Project\Core\Application;
use Project\Core\Database\Model;

class Posts_Tags extends Model {
    protected static string $table_name                = 'posts_tags';
    public static array $foreign_keys                  = [
        'post_id' => ['posts' => 'id'],
        'tag_id' => ['tags' => 'id']
    ];
    
    public static function requiredAttributes(): array {
        return ['post_id', 'tag_id'];
    }
    public static function editableAttributes(): array {
        return []; 
    }
}