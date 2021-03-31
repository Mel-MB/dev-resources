<?php

namespace Project\Models;

use Project\Core\Database\Model;

class User extends Model{
    private const TABLE_NAME                = 'tags';
    protected const PRIMARY_KEY             = 'id';
    private const RELATIONNAL_TABLE       = [
        'tableName' => 'posts_tags',
        'foreignKeys'=> [
            'post_id' => ['posts' => 'id'],
            'tag_id' => ['tags' => 'id'],
        ]
    ];

    public function __construct(string $tableName = null){
        self::$tableName = self::TABLE_NAME;
        self::$primaryKey = self::PRIMARY_KEY;
    }
    public static function uniqueAttributes(): array {
        return ['username', 'email'];
    }
    public static function requiredAttributes(): array {
        return ['username', 'email', 'promotion', 'password'];
    }
    public static function editableAttributes(): array {
        return ['username', 'email', 'promotion','job', 'own_website','github','linkedin','discord','codepen'];
    }
}