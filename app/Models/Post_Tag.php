<?php

namespace Project\Models;

use Project\Core\Database\Model;

class Post_Tag extends Model{
    private const TABLE_NAME      = 'posts_tags';
    protected const FOREIGN_KEYS  = [
        'post_id' => ['posts' => 'id'],
        'tag_id' => ['tags' => 'id'],
    ];

    public function __construct(string $tableName = null){
        self::$tableName = self::TABLE_NAME;
    }
    public static function requiredAttributes(): array {
        return ['post_id', 'tag_id'];
    }
    public static function editableAttributes(): array {
        return [];
    }
}