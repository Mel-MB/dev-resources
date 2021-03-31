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
        return ['username', 'email', 'promotion', 'password'];
    }
    public static function editableAttributes(): array {
        return ['username', 'email', 'promotion','job', 'own_website','github','linkedin','discord','codepen'];
    }
}