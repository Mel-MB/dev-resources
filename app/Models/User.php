<?php

namespace Project\Models;

use Project\Core\Database\Model;

class User extends Model{
    protected static string $table_name     = 'users';
    public static string $primary_key       = 'id';

    public static function uniqueAttributes(): array {
        return ['username', 'email'];
    }
    public static function requiredAttributes(): array {
        return ['username', 'email', 'password'];
    }
    public static function editableAttributes(): array {
        return ['username', 'email', 'tags','job', 'own_website','github','linkedin','discord','codepen'];
    }

    public static function getRole($userId){
        $table = self::$table_name;
        $request = self::prepare("SELECT `role` FROM  $table  WHERE  id = ?");
        $request->execute([$userId]);
        $result = $request->fetch();
        return $result->role;
    }
}